<?php

namespace App\Http\Controllers\Api;

use OpenApi\Annotations as OA;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\NewUserRequest;
use App\Http\Resources\Api\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * @OA\Info(
 *     version="1.0",
 *     title="AuthController"
 * )
 */
class AuthController extends Controller
{
    /**
     * Register new user.
     *
     * @param NewUserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(NewUserRequest $request)
    {
        $attributes = $request->validated();

        $attributes['password'] = Hash::make($attributes['password']);

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
     * @param \App\Http\Requests\Api\LoginRequest $request
     * @return \App\Http\Resources\Api\UserResource|\Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        Auth::shouldUse('web');

        if (Auth::attempt($request->validated())) {
            return new UserResource(Auth::user());
        }

        return response()->json([
            'message' => trans('validation.invalid'),
            'errors' => [
                'user' => [trans('auth.failed')],
            ],
        ], 422);
    }
}
