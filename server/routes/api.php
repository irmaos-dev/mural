<?php

declare(strict_types = 1);

use App\Http\Controllers\Api\Articles\ArticleController;
use App\Http\Controllers\Api\Articles\CommentsController;
use App\Http\Controllers\Api\Articles\FavoritesController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\TagsController;
use App\Http\Controllers\Api\UserController;
use App\Http\Resources\Api\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::name('api.')->group(function (): void {
    Route::name('users.')->group(function (): void {
        Route::middleware('auth:api')->group(function (): void {
            Route::get('user', [UserController::class, 'show'])->name('current');
            Route::put('user', [UserController::class, 'update'])->name('update');
        });

        Route::post('users/login', [AuthController::class, 'login'])->name('login');
        Route::post('users', [AuthController::class, 'register'])->name('register');
    });

    Route::name('profiles.')->group(function (): void {
        Route::middleware('auth:api')->group(function (): void {
            Route::post('profiles/{username}/follow', [ProfileController::class, 'follow'])->name('follow');
            Route::delete('profiles/{username}/follow', [ProfileController::class, 'unfollow'])->name('unfollow');
        });

        Route::get('profiles/{username}', [ProfileController::class, 'show'])->name('get');
    });

    Route::name('articles.')->group(function (): void {
        Route::middleware('auth:api')->group(function (): void {
            Route::get('articles/feed', [ArticleController::class, 'feed'])->name('feed');
            Route::post('articles', [ArticleController::class, 'create'])->name('create');
            Route::put('articles/{slug}', [ArticleController::class, 'update'])->name('update');
            Route::delete('articles/{slug}', [ArticleController::class, 'delete'])->name('delete');
        });

        Route::get('articles', [ArticleController::class, 'list'])->name('list');
        Route::get('articles/{slug}', [ArticleController::class, 'show'])->name('get');

        Route::name('comments.')->group(function (): void {
            Route::middleware('auth:api')->group(function (): void {
                Route::post('articles/{slug}/comments', [CommentsController::class, 'create'])->name('create');
                Route::delete('articles/{slug}/comments/{id}', [CommentsController::class, 'delete'])->name('delete');
            });

            Route::get('articles/{slug}/comments', [CommentsController::class, 'list'])->name('get');
        });

        Route::name('favorites.')->group(function (): void {
            Route::middleware('auth:api')->group(function (): void {
                Route::post('articles/{slug}/favorite', [FavoritesController::class, 'add'])->name('add');
                Route::delete('articles/{slug}/favorite', [FavoritesController::class, 'remove'])->name('remove');
            });
        });
    });

    Route::name('tags.')->group(function (): void {
        Route::get('tags', [TagsController::class, 'list'])->name('list');
    });

    Route::name('auth.')->group(function () {
        Route::get('auth/redirect', function () {
            return Socialite::driver('google')
                ->stateless()
                ->with(['access_type' => 'offline', 'prompt' => 'consent',])
                ->redirect();
        });

        Route::get('auth/callback', function () {
            $googleUser = Socialite::driver('google')->stateless()->user();

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
                    'image' => $googleUser->avatar,
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

            return redirect()->to("http://127.0.0.1:5173/?user={$userData}");

        });
    });
});
