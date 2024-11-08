<?php

declare(strict_types = 1);

namespace Tests\Feature\Api\Article;

use App\Models\Article;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

final class ShowArticleTest extends TestCase
{
    public function testShowArticleWithoutAuth(): void
    {
        /** @var Article $article */
        $article = Article::factory()->state([
            "image" => "https://example.com/image.png",
        ])
            ->has(Tag::factory()->count(5), "tags")
            ->for(
                User::factory()->state([
                    "bio"   => "not-null",
                    "image" => "https://example.com/image.png",
                ]),
                "author"
            )
            ->create();
        $author = $article->author;
        $tags = $article->tags;

        $response = $this->getJson("/api/articles/{$article->slug}");

        $response->assertOk()->assertJson(
            fn (AssertableJson $json) => $json->has(
                "article",
                fn (AssertableJson $item) => $item
                    ->whereAll([
                        "slug"           => $article->slug,
                        "title"          => $article->title,
                        "image"          => $article->image,
                        "description"    => $article->description,
                        "body"           => $article->body,
                        "tagList"        => $tags->pluck("name"),
                        "createdAt"      => $article->created_at?->toISOString(),
                        "updatedAt"      => $article->updated_at?->toISOString(),
                        "favoritesCount" => 0,
                        "favorited"      => false,
                    ])
                    ->has(
                        "author",
                        fn (AssertableJson $subItem) => $subItem->whereAll([
                            "username"  => $author->username,
                            "bio"       => $author->bio,
                            "following" => false,
                            "image"     => $author->image,
                        ])
                    )
            )
        );
    }

    public function testShowFavoredArticleWithUnfollowedAuthor(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        /** @var Article $article */
        $article = Article::factory()
            ->hasAttached($user, [], "favoredUsers")
            ->create();

        $this->assertTrue($article->favoredUsers->contains($user));

        $response = $this->actingAs($user)->getJson(
            "/api/articles/{$article->slug}"
        );

        $response
            ->assertOk()
            ->assertJsonPath("article.favorited", true)
            ->assertJsonPath("article.favoritesCount", 1)
            ->assertJsonPath("article.author.following", false);
    }

    public function testShowUnfavoredArticleWithFollowedAuthor(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        /** @var User $author */
        $author = User::factory()
            ->hasAttached($user, [], "followers")
            ->create();
        /** @var Article $article */
        $article = Article::factory()->for($author, "author")->create();

        $this->assertTrue($author->followers->contains($user));

        $response = $this->actingAs($user)->getJson(
            "/api/articles/{$article->slug}"
        );

        $response
            ->assertOk()
            ->assertJsonPath("article.favorited", false)
            ->assertJsonPath("article.favoritesCount", 0)
            ->assertJsonPath("article.author.following", true);
    }

    public function testShowNonExistentArticle(): void
    {
        $this->getJson("/api/articles/non-existent")->assertNotFound();
    }
}
