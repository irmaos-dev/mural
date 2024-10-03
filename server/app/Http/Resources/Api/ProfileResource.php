<?php

declare(strict_types = 1);

namespace App\Http\Resources\Api;

final class ProfileResource extends BaseUserResource
{
    /**
     * The "data" wrapper that should be applied.
     *
     * @var string
     */
    public static $wrap = 'profile';

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        /** @var \App\Models\User|null $user */
        $user = $request->user();

        return array_merge(parent::toArray($request), [
            // 'following' => $this->when($user !== null, fn() =>
            //     $user->following($this->resource)
            // ),
            'following' => null !== $user ? $user->following($this->resource) : false,
        ]);
    }
}
