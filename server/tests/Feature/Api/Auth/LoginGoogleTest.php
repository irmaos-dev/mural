<?php

declare(strict_types = 1);

namespace Tests\Feature\Api\Auth;

use App\Http\Resources\Api\UserResource;
use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use League\OAuth2\Server\ResponseTypes\RedirectResponse;
use Mockery;
use Socialite;
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

    public function testSignInWithGoogle(): void{

        $socialiteUser = Mockery::mock('Laravel\Socialite\Two\User');

        $socialiteUser->name='Teste';
        $socialiteUser->id='123';
        $socialiteUser->email='email@test.dev';
        $socialiteUser->token='123';
        $socialiteUser->refreshToken='123';

        Socialite::shouldReceive('driver->stateless->user')->andReturn($socialiteUser);

        $this->getJson("/api/auth/callback")
            ->assertRedirectContains(config('frontend.url'))
            -> assertRedirectContains($socialiteUser->name);

        $this-> assertDatabaseHas ('users', [
                'name' => "Teste",
                'email' => "email@test.dev",
                'google_id' => "123",
                'google_token' => "123",
                'google_refresh_token' => "123",
                ] );
    }

    public function testLoginWithGoogle(): void{

        $user = User::factory()->create();

        $socialiteUser = Mockery::mock('Laravel\Socialite\Two\User');

        $socialiteUser->id=$user->google_id;
        $socialiteUser->name="Teste Login";
        $socialiteUser->email=$user->email;
        $socialiteUser->token="login123";
        $socialiteUser->refreshToken="login123";
        $socialiteUser->avatar="https://irmaos.dev/logo.png";
        $socialiteUser->username="Teste Username";       
            
        Socialite::shouldReceive('driver->stateless->user')->andReturn($socialiteUser);

        $this->getJson("/api/auth/callback")
            ->assertRedirectContains(config('frontend.url'))
            -> assertRedirectContains($user->username);

        $this-> assertDatabaseHas ('users', [
                'google_id' => $user->google_id,
                'name' => "Teste Login",
                'email' => $user->email,
                'google_token' => "login123",
                'google_refresh_token' => "login123",
                'image' => $user->image,
                'username' => $user->username
                ] );
    }

    public function testRedirectsToException(): void
    {
        $this->getJson("/api/auth/callback")
            ->assertRedirect(config('frontend.url'));
    }
}
