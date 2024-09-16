<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\NewUserRequest;
use App\Http\Resources\Api\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Info(
 *     version="1.0",
 *     title="AuthController"
 * )
 */
final class AuthController extends Controller
{
    /**
     * Register new user.
     *
     * @param NewUserRequest $request
     * @return JsonResponse
     */
    public function register(NewUserRequest $request): JsonResponse
    {
        $attributes = $request->validated();

        $user = User::create($attributes);

        return (new UserResource($user))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * @OA\Post(
     *     path="/login",
     *     summary="Login to the application",
     *     description="Authenticate user with username and password",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"username","password"},
     *             @OA\Property(property="username", type="string", example="user123"),
     *             @OA\Property(property="password", type="string", example="password123")
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful login",
     *         @OA\JsonContent(
     *             @OA\Property(property="token", type="string", example="eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Invalid credentials")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Username and password are required")
     *         )
     *     )
     * )
     *
     * Login existing user.
     *
     * @param LoginRequest $request
     * @return UserResource|JsonResponse
     */
    public function login(LoginRequest $request): UserResource|JsonResponse
    {
        Auth::shouldUse('web');

        if (Auth::attempt($request->validated())) {
            return response()->json([
                'user' => new UserResource(Auth::user()),
            ], 200);
        }

        return response()->json([
            'message' => trans('validation.invalid'),
            'errors'  => [
                'user' => [trans('auth.failed')],
            ],
        ], 422);
    }
}
