<?php

declare(strict_types = 1);

namespace Tests\Feature\Api\Article;

use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

final class UpdateArticleTest extends TestCase
{
    use WithFaker;

    private Article $article;

    protected function setUp(): void
    {
        parent::setUp();

        /** @var Article $article */
        $article = Article::factory()
            ->for(
                User::factory()->state([
                    "bio"   => "not-null",
                    "image" => "https://example.com/image.png",
                ]),
                "author"
            )
            ->create();
        $this->article = $article;
    }

    public function testUpdateArticle(): void
    {
        $author = $this->article->author;

        $this->assertNotEquals($title = "Updated title", $this->article->title);
        $this->assertNotEquals(
            $image = "https://test-image.fake/imageid",
            $this->article->image
        );
        $this->assertNotEquals(
            $fakeSlug = "overwrite-slug",
            $this->article->slug
        );
        $this->assertNotEquals(
            $description = "New description.",
            $this->article->description
        );
        $this->assertNotEquals(
            $body = "Updated article body.",
            $this->article->body
        );

        // update by one to check required_without_all rule
        $this->actingAs($author)
            ->putJson("/api/articles/{$this->article->slug}", [
                "article" => [
                    "description" => $description,
                    "image"       => $image,
                    "body"        => $body],
            ])
            ->assertOk();

        $response = $this->actingAs($author)->putJson(
            "/api/articles/{$this->article->slug}",
            [
                "article" => [
                    "title" => $title,
                    "slug"  => $fakeSlug, // must be overwritten with title slug
                ],
            ]
        );

        $response->assertOk()->assertJson(
            fn (AssertableJson $json) => $json->has(
                "article",
                fn (AssertableJson $item) => $item
                    ->whereType("updatedAt", "string")
                    ->whereAll([
                        "slug"           => "updated-title",
                        "title"          => $title,
                        "description"    => $description,
                        "image"          => $image,
                        "body"           => $body,
                        "tagList"        => [],
                        "createdAt"      => $this->article->created_at?->toISOString(),
                        "favorited"      => false,
                        "favoritesCount" => 0,
                    ])
                    ->has(
                        "author",
                        fn (AssertableJson $subItem) => $subItem->whereAll([
                            "username"  => $author->username,
                            "bio"       => $author->bio,
                            "image"     => $author->image,
                            "following" => false,
                        ])
                    )
            )
        );
    }

    public function testUpdateForeignArticle(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)->putJson(
            "/api/articles/{$this->article->slug}",
            [
                "article" => [
                    "body" => $this->faker->text(),
                ],
            ]
        );

        $response->assertForbidden();
    }

    /**
     * @dataProvider articleProvider
     * @param array<mixed> $data
     * @param string|array<string> $errors
     */
    public function testUpdateArticleValidation(array $data, $errors): void
    {
        $data = [
            'title'       => '',
            'image'       => '',
            'body'        => 'Some valid body content',
            'description' => 'Some description',
        ];

        $response = $this->actingAs($this->article->author)->putJson(
            "/api/articles/{$this->article->slug}",
            $data
        );

        $response->assertUnprocessable()->assertInvalid($errors);
    }

    public function testSelfUpdateArticleValidationUnique(): void
    {
        $response = $this->actingAs($this->article->author)->putJson(
            "/api/articles/{$this->article->slug}",
            [
                "article" => [
                    "title" => $this->article->title,
                ],
            ]
        );

        $response
            ->assertOk()
            ->assertJsonPath("article.slug", $this->article->slug);
    }

    public function testUpdateNonExistentArticle(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)->putJson(
            "/api/articles/non-existent",
            [
                "article" => [
                    "body" => $this->faker->text(),
                ],
            ]
        );

        $response->assertNotFound();
    }

    public function testUpdateArticleWithoutAuth(): void
    {
        $response = $this->putJson("/api/articles/{$this->article->slug}", [
            "article" => [
                "body" => $this->faker->text(),
            ],
        ]);

        $response->assertUnauthorized();
    }

    /**
     * @return array<int|string, array<mixed>>
     */
    public static function articleProvider(): array
    {
        $errors = ["title", "description", "body"];

        return [
            "required"    => [[], $errors],
            "not strings" => [
                [
                    "article" => [
                        "title"       => 123,
                        "description" => [],
                        "body"        => null,
                    ],
                ],
                $errors,
            ],
            "empty strings" => [
                [
                    "article" => [
                        "title"       => "",
                        "image"       => "",
                        "description" => "",
                        "body"        => "",
                    ],
                ],
                $errors,
            ],
        ];
    }

    public function testUpdateArticleSlugModifier(): void
    {

        $slugOriginal = $this->article->slug;

        $articleTitleEdited = $this->faker->sentence(5);
        $response2 = $this->actingAs($this->article->author)->putJson("/api/articles/{$slugOriginal}", [
            "article" => [
                "title" => $articleTitleEdited,
            ],
        ]);

        $slugEdited = $response2->decodeResponseJson()['article']['slug'];
        $this->assertNotEquals($slugOriginal, $slugEdited, 'O slug deve ser modificado após a edição do título.');

    }

    public function testSlugIsUniqueWhenTitleIsDuplicated(): void
    {

        $article1Title = $this->article->title;
        $article1Slug = $this->article->slug;

        $article2 = Article::factory()->for($this->article->author, 'author')->create();
        $article2Slug = $article2->slug;

        $response = $this->actingAs($article2->author)->putJson("/api/articles/{$article2Slug}", [
            "article" => [
                "title" => $article1Title,
            ],
        ]);

        $article2SlugEdited = $article2->fresh()->slug;
        $this->assertNotEquals($article1Slug, $article2SlugEdited);
    }

    public function testUpdateSlugIgnoresManualInput(): void
    {

        $articleSlug = $this->article->slug;
        $manualSlugAttempt = "manual-slug-attempt";
        $response2 = $this->actingAs($this->article->author)->putJson("/api/articles/{$articleSlug}", [
            "article" => [
                "title" => `{$this->article->title} edited`,
                "slug"  => $manualSlugAttempt,
            ], ]);

        $articleSlugEdited = $this->article->fresh()->slug;

        $this->assertNotEquals($manualSlugAttempt, $articleSlugEdited);
    }

    public function testUpdateTagsIncludesNewTag(): void
    {
        $this->article->syncTags($this->faker->words(3));
        $articleSlug = $this->article->slug;

        $articleTagsIncludedNewTag = [...$this->article->tagList, "new-tag"];

        $response = $this->actingAs($this->article->author)->putJson("/api/articles/{$articleSlug}", [
            "article" => [
                "title"   => $this->article->title,
                "tagList" => $articleTagsIncludedNewTag,
            ],
        ]);

        $articleTagsUpdated = $this->article->fresh()->tagList;

        $this->assertEquals($articleTagsIncludedNewTag, $articleTagsUpdated);
    }

    public function testUpdateAllTags(): void
    {
        $this->article->syncTags($this->faker->words(3));

        $articleSlug = $this->article->slug;
        $articleTags = $this->article->tagList;

        $response = $this->actingAs($this->article->author)->putJson("/api/articles/{$articleSlug}", [
            "article" => [
                "title"   => $this->article->title,
                "tagList" => ["new-tag"],
            ],
        ]);

        $articleTagsUpdated = $this->article->fresh()->tagList;

        $this->assertNotEquals($articleTags, $articleTagsUpdated);
    }

    public function testUpdateTagsEmpty(): void
    {

        $this->article->syncTags($this->faker->words(3));

        $articleSlug = $this->article->slug;

        $response2 = $this->actingAs($this->article->author)->putJson("/api/articles/{$articleSlug}", [
            "article" => [
                "title"   => $this->article->title,
                "tagList" => [],
            ],
        ]);

        $articleTagsUpdated = $this->article->fresh()->tagList;

        $this->assertEmpty($articleTagsUpdated);
    }
}
