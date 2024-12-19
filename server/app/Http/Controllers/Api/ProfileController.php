<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\ProfileResource;
use App\Models\User;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     version="1.0",
 *     title="ProfileController"
 * )
 */
final class ProfileController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param string $username
     * @return ProfileResource
     *
     * @OA\Post(
     *     path="/profiles/{username}",
     *     summary="GET profiles by username",
     *     description="Pegar as informações do perfil de um usuário buscando pelo seu username",
     *     @OA\Parameter(
     *      parameter="username",
     *      name="username",
     *      description="O username/slug do usuário. Aparece na URL do perfil do usuário.",
     *      @OA\Schema(
     *          type="string"
     *      ),
     *      in="query",
     *      required=true
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="User was not found")
     *         )
     *     )
     * )
     */
    public function show(string $username)
    {
        $profile = User::whereUsername($username)
            ->firstOrFail();

        return new ProfileResource($profile);
    }

    /**
     * Follow an author.
     *
     * @param Request $request
     * @param string $username
     * @return ProfileResource
     */
    public function follow(Request $request, string $username)
    {
        $profile = User::whereUsername($username)
            ->firstOrFail();

        $profile->followers()
            ->syncWithoutDetaching($request->user());
        $this->logFollowUnfollow($request, $profile, 'follow');

        return new ProfileResource($profile);
    }

    /**
     * Unfollow an author.
     *
     * @param Request $request
     * @param string $username
     * @return ProfileResource
     */
    public function unfollow(Request $request, string $username)
    {
        $profile = User::whereUsername($username)
            ->firstOrFail();

        $profile->followers()->detach($request->user());
        $this->logFollowUnfollow($request, $profile, 'unfollow');

        return new ProfileResource($profile);
    }

    private function logFollowUnfollow(Request $request, User $profile, string $action): void
    {
        $follower_id = $request->user()->id;
        $author_id = $profile->id;
        $actionMessage = 'follow' === $action ? 'começou a seguir' : 'deixou de seguir';
        activity('FollowAction')
            ->performedOn($profile)
            ->causedBy($request->user())
            ->event($action)
            ->withProperties([
                'follower_id' => $follower_id,
                'followed_id' => $author_id,
            ])
            ->log("Usuário de id:'{$follower_id}' {$actionMessage} o usuário de id:'{$author_id}'");
    }

}
