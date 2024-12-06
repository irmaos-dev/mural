<?php

declare(strict_types = 1);

namespace Tests\Feature\Api\Auth;

use App\Jwt;
use App\Models\User;
use Spatie\Activitylog\Facades\CauserResolver;
use Tests\TestCase;

final class JwtGuardTest extends TestCase
{
    private User $user;

    private string $token;

    protected function setUp(): void
    {
        parent::setUp();

        /** @var User $user */
        CauserResolver::resolveUsing(function (): void {});
        $user = User::factory()->create();
        CauserResolver::resolveUsing(function ($subject) {
            if ($subject instanceof Model) {
                return $subject;
            }
        });

        $this->user = $user;
        $this->token = Jwt\Generator::token($user);
    }

    public function testGuardTokenParse(): void
    {
        $this->getJson("/api/user?token=string")->assertUnauthorized();
    }

    public function testGuardTokenValidation(): void
    {
        $this->user->delete();

        $this->getJson("/api/user?token={$this->token}")->assertUnauthorized();
    }

    public function testGuardWithHeaderToken(): void
    {
        $response = $this->getJson("/api/user", [
            "Authorization" => "Bearer {$this->token}",
        ]);

        $response->assertOk();
    }

    public function testGuardWithQueryToken(): void
    {
        $this->getJson("/api/user?token={$this->token}")->assertOk();
    }

    public function testGuardWithJsonBodyToken(): void
    {
        $response = $this->json("GET", "/api/user", [
            "token" => $this->token,
        ]);

        $response->assertOk();
    }
}
