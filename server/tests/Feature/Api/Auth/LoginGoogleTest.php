<?php

declare(strict_types = 1);

namespace Tests\Feature\Api\Auth;

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Socialite\Facades\Socialite;
use Mockery;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

final class LoginGoogleTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function testRedirectsToGoogleSignIn(): void
    {
        $this->getJson("/api/auth/redirect")
            ->assertRedirectContains("https://accounts.google.com/o/oauth2/auth?client_id=");
    }

    public function testSignInWithGoogle(): void
    {

        $socialiteUser = Mockery::mock('Laravel\Socialite\Two\User');

        // @phpstan-ignore-next-line
        $socialiteUser->name = 'Teste';
        // @phpstan-ignore-next-line
        $socialiteUser->id = '123';
        // @phpstan-ignore-next-line
        $socialiteUser->email = 'email@test.dev';
        // @phpstan-ignore-next-line
        $socialiteUser->token = '123';
        // @phpstan-ignore-next-line
        $socialiteUser->refreshToken = '123';

        Socialite::shouldReceive('driver->stateless->user')->andReturn($socialiteUser);

        $this->getJson("/api/auth/callback")
            ->assertRedirectContains(config('frontend.url'))
            -> assertRedirectContains($socialiteUser->name);

        $this-> assertDatabaseHas('users', [
            'name'                 => "Teste",
            'email'                => "email@test.dev",
            'google_id'            => "123",
            'google_token'         => "123",
            'google_refresh_token' => "123",
        ]);
    }

    public function testLoginWithGoogle(): void
    {

        $user = User::factory()->create();

        $socialiteUser = Mockery::mock('Laravel\Socialite\Two\User');

        // @phpstan-ignore-next-line
        $socialiteUser->id = $user->google_id;
        // @phpstan-ignore-next-line
        $socialiteUser->name = "Teste Login";
        // @phpstan-ignore-next-line
        $socialiteUser->email = $user->email;
        // @phpstan-ignore-next-line
        $socialiteUser->token = "login123";
        // @phpstan-ignore-next-line
        $socialiteUser->refreshToken = "login123";
        // @phpstan-ignore-next-line
        $socialiteUser->username = "TesteUsername";
        // @phpstan-ignore-next-line
        $socialiteUser->avatar = "https://irmaos.dev/logo.png";

        Socialite::shouldReceive('driver->stateless->user')->andReturn($socialiteUser);

        $this->getJson("/api/auth/callback")
            ->assertRedirectContains(config('frontend.url'))
            -> assertRedirectContains($user->username);

        $this-> assertDatabaseHas('users', [
            'google_id'            => $user->google_id,
            'name'                 => "Teste Login",
            'email'                => $user->email,
            'google_token'         => "login123",
            'google_refresh_token' => "login123",
            'image'                => $user->image,
            'username'             => $user->username,
        ]);
    }

    public function testRedirectsToException(): void
    {
        $this->getJson("/api/auth/callback")
            ->assertRedirect(config('frontend.url'));
    }

    public function testAssignAdmin(): void
    {
        $usersCountSeeder = DatabaseSeeder::$usersCount;

        /** @var User $user */
        for ($i = 1; $i <= $usersCountSeeder; $i++) {
            $user = User::factory()->create();
        }

        Role::create(['name' => 'Admin']);

        $socialiteUser = Mockery::mock('Laravel\Socialite\Two\User');

        $email = 'email@test.dev';

        // @phpstan-ignore-next-line
        $socialiteUser->name = 'Teste';
        // @phpstan-ignore-next-line
        $socialiteUser->id = '123';
        // @phpstan-ignore-next-line
        $socialiteUser->email = $email;
        // @phpstan-ignore-next-line
        $socialiteUser->token = '123';
        // @phpstan-ignore-next-line
        $socialiteUser->refreshToken = '123';

        Socialite::shouldReceive('driver->stateless->user')->andReturn($socialiteUser);

        $this->getJson("/api/auth/callback");

        $usersAdminCount = User::role('Admin')->count();
        $this->assertEquals(1, $usersAdminCount);

        $usersAdmin = User::role('Admin')->get();
        $userEmail = $usersAdmin->first()->email;
        $this->assertEquals($email, $userEmail);

        $socialiteUser2 = Mockery::mock('Laravel\Socialite\Two\User');

        $email2 = 'email2@test.dev';

        // @phpstan-ignore-next-line
        $socialiteUser->name = 'Teste 2';
        // @phpstan-ignore-next-line
        $socialiteUser->id = '1234';
        // @phpstan-ignore-next-line
        $socialiteUser->email = $email2;
        // @phpstan-ignore-next-line
        $socialiteUser->token = '123';
        // @phpstan-ignore-next-line
        $socialiteUser->refreshToken = '123';

        Socialite::shouldReceive('driver->stateless->user')->andReturn($socialiteUser2);

        $this->getJson("/api/auth/callback");

        $this->assertEquals(1, $usersAdminCount);

        $usersAdmin = User::role('Admin')->get();
        $userEmail2 = $usersAdmin->first()->email;
        $this->assertNotEquals($email2, $userEmail2);
    }

}
