<?php

declare(strict_types = 1);

namespace Tests\Feature\Api\Auth;

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

        $socialiteUser
            ->shouldReceive('getId')->andReturn('12345654321345')
            ->shouldReceive('getName')->andReturn("Nome Teste")
            ->shouldReceive('getEmail')->andReturn("email@test.com")
            ->shouldReceive('getAvatar')->andReturn('https://en.gravatar.com/userimage');

        Socialite::shouldReceive('driver->user')->andReturn($socialiteUser);

        $this->postJson("/api/auth/callback");

        // $this-> assertDatabaseHas ('users', [
        //         'username' => "Nome Teste",
        //         'email' => "email@test.com",
        //         'google_id' => "12345654321345",
        //         // 'google_token' => $user->google_token,
        //         // 'google_refresh_token' => $user->google_refresh_token,
        //         ] );

        // $this->get(route('oauth.callback', 'google'))->assertRedirect(route('dashboard'));
        // expect(auth()->check())->toBeTrue();
















        // $user = Socialite::driver('google');
        // ->andReturn($socialiteUser);

        //  = User::factory()->create();

        // $this->postJson("/api/auth/callback");
        //  ->assertRedirect(config('frontend.url'));

        // $this-> assertDatabaseHas ('users', [
        //     'username' => $user->username,
        //     'email' => $user->email,
        //     'google_id' => $user->google_id,
        //     'google_token' => $user->google_token,
        //     'google_refresh_token' => $user->google_refresh_token,
        //     ] );



        // $googleId = '12345654321345';
    
        // $socialiteUser
        // ->shouldReceive('getId')->andReturn($googleId = '12345654321345')
        // ->shouldReceive('getName')->andReturn($user->name)
        // ->shouldReceive('getEmail')->andReturn($user->email)
        // ->shouldReceive('getAvatar')->andReturn($avatarUrl = 'https://en.gravatar.com/userimage');

        // Socialite::shouldReceive('driver->user')->andReturn($socialiteUser);
    
        
    
        // $this->getJson(route("api/auth/callback", 'google'))->assertRedirect(route(config('frontend.url')));
        // expect(auth()->check())->toBeTrue();
    
        

    }
}
