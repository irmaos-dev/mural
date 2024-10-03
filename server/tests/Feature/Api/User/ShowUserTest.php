<?php

declare(strict_types = 1);

namespace Tests\Feature\Api\User;

use App\Jwt;
use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

final class ShowUserTest extends TestCase
{
    public function testShowUser(): void
    {
        /** @var User $user */
        $user = User::factory()->create([
            "bio"   => "test bio",
            "image" => "https://test-image.fake/imageid",
        ]);

        $response = $this->actingAs($user)->getJson("/api/user");

        $response->assertOk()->assertJson(
            fn (AssertableJson $json) => $json->has(
                "user",
                fn (AssertableJson $item) => $item
                    ->whereType("token", "string")
                    ->whereAll([
                        "username" => $user->username,
                        "email"    => $user->email,
                        "bio"      => $user->bio,
                        "image"    => $user->image,
                    ])
            )
        );

        $token = Jwt\Parser::parse($response["user"]["token"]);
        $this->assertTrue(Jwt\Validator::validate($token));
    }

    public function testShowUserWithoutAuth(): void
    {
        $this->getJson("/api/user")->assertUnauthorized();
    }
}
