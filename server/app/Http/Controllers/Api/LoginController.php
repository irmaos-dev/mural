<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\UserResource;
use App\Models\User;
use Exception;
use Laravel\Socialite\Facades\Socialite;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    public function redirect()
    {
        // @phpstan-ignore-next-line
        return Socialite::driver('google')
            ->stateless()
            ->with(['access_type' => 'offline', 'prompt' => 'consent', ])
            ->redirect();
    }

    public function callback()
    {
        try {
            /** @var \Laravel\Socialite\Two\GoogleProvider  */
            $provider = Socialite::driver('google');
            /** @var \Laravel\Socialite\Two\User  */
            $googleUser = $provider->stateless()->user();
        } catch (Exception) {
            return redirect()->to(config('frontend.url'));
        }

        $usersCountDB = DB::table('users')->count();
        $usersCountSeeder = DatabaseSeeder::$usersCount;

        $name = explode(" ", $googleUser->name);

        do {
            $num_rand = rand(10000000, 99999999);
            $username = $name[0] . "@" . $num_rand;
        } while (User::where(['username' => $username])->exists());

        if (User::where(['google_id' => $googleUser->id])->exists()) {
            $user = User::where(['google_id' => $googleUser->id])->first();
            $user->update([
                'name'                 => $googleUser->name,
                'google_token'         => $googleUser->token,
                'google_refresh_token' => $googleUser->refreshToken,
            ]);
        } else {
            $user = User::create([
                'google_id'            => $googleUser->id,
                'username'             => $username,
                'name'                 => $googleUser->name,
                'email'                => $googleUser->email,
                'google_token'         => $googleUser->token,
                'google_refresh_token' => $googleUser->refreshToken,
                'image'                => $googleUser->avatar,
            ]);
        }

        if ($usersCountDB == ($usersCountSeeder+1)){
            $user->assignRole('Admin');
        }

        $userData = urlencode(json_encode(new UserResource($user)));

        return redirect()->to(config('frontend.url') . "/?user={$userData}");
    }
}
