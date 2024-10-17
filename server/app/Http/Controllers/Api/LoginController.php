<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\UserResource;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    public function redirect(){
        return Socialite::driver('google')
        ->stateless()
        ->with(['access_type' => 'offline', 'prompt' => 'consent',])
        ->redirect();
    }

    public function callback(){
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
        } catch (\Exception){
            return redirect()->to(config('frontend.url'));
        }

            $name = explode(" ", $googleUser->name);
            
            do {
                $num_rand = rand(10000000, 99999999);
                $username = $name[0] . "@" . $num_rand;
            } while (User::where(['username' => $username])->exists());

            if (User::where(['google_id' => $googleUser->id])->exists()) {
                $user = User::where(['google_id' => $googleUser->id])->first();
                $user->update([
                    'name' => $googleUser->name,
                    'google_token' => $googleUser->token,
                    'google_refresh_token' => $googleUser->refreshToken,
                ]);
            } else {
                $user = User::create([
                    'google_id' => $googleUser->id,
                    'username' => $username,
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_token' => $googleUser->token,
                    'google_refresh_token' => $googleUser->refreshToken,
                    'image' => $googleUser->avatar,
                ]);
            }

            $userData = urlencode(json_encode(new UserResource($user)));

            return redirect()->to(config('frontend.url')."/?user={$userData}");
    }
}
