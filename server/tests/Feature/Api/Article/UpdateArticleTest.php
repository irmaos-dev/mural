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
        /** @var User $author */
        $author = User::factory()->create();

        $articleTitle = $this->faker->sentence(4);

        $response = $this->actingAs($author)->postJson("/api/articles", [
            "article" => [
                "title"       => $articleTitle,
                "image"       => $this->faker->imageUrl(),
                "description" => $this->faker->paragraph(),
                "body"        => $this->faker->text(),
                "tagList"     => [],
            ],
        ]);

        $slugOriginal = $response->decodeResponseJson()['article']['slug'];

        $articleTitleEdited = $this->faker->sentence(5);
        $response2 = $this->actingAs($author)->putJson("/api/articles/{$slugOriginal}", [
            "article" => [
                "title" => $articleTitleEdited,
            ],
        ]);

        $slugEdited = $response2->decodeResponseJson()['article']['slug'];
        $this->assertNotEquals($slugOriginal, $slugEdited, 'O slug deve ser modificado após a edição do título.');

    }

    public function testSlugIsUniqueWhenTitleIsDuplicated(): void
    {
        /** @var User $author */
        $author = User::factory()->create();

        $articleTitle = $this->faker->sentence(4);

        $response = $this->actingAs($author)->postJson("/api/articles", [
            "article" => [
                "title"       => $articleTitle,
                "image"       => $this->faker->imageUrl(),
                "description" => $this->faker->paragraph(),
                "body"        => $this->faker->text(),
                "tagList"     => [],
            ],
        ]);

        $slug = $response->decodeResponseJson()['article']['slug'];

        $response2 = $this->actingAs($author)->postJson("/api/articles", [
            "article" => [
                "title"       => $this->faker->sentence(4),
                "image"       => $this->faker->imageUrl(),
                "description" => $this->faker->paragraph(),
                "body"        => $this->faker->text(),
                "tagList"     => [],
            ],
        ]);

        $slug2 = $response2->decodeResponseJson()['article']['slug'];

        $response3 = $this->actingAs($author)->putJson("/api/articles/{$slug2}", [
            "article" => [
                "title" => $articleTitle,
            ],
        ]);

        $slug2Edited = $response3->decodeResponseJson()['article']['slug'];
        $this->assertNotEquals($slug, $slug2Edited);
    }

    public function testUpdateSlugIgnoresManualInput(): void
    {
        /** @var User $author */
        $author = User::factory()->create();

        $response = $this->actingAs($author)->postJson("/api/articles", [
            "article" => [
                "title"       => "Test title",
                "image"       => $this->faker->imageUrl(),
                "description" => $this->faker->paragraph(),
                "body"        => $this->faker->text(),
                "tagList"     => [],
            ],
        ]);

        $slug = $response->decodeResponseJson()['article']['slug'];

        $response2 = $this->actingAs($author)->putJson("/api/articles/{$slug}", [
            "article" => [
                "title" => "Test title edited",
                "slug"  => "Slug edited",
            ], ]);

        $slug2 = $response2->decodeResponseJson()['article']['slug'];

        $this->assertEquals("test-title-edited", $slug2);
    }

}
