<?php

declare(strict_types = 1);

namespace App\Http\Resources\Api;

use App\Jwt;

final class UserResource extends BaseUserResource
{
    /**
     * The "data" wrapper that should be applied.
     *
     * @var string
     */
    public static $wrap = 'user';

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'username' => $this->resource->username ?? null,
            'email'    => $this->resource->email,
            'bio'      => $this->resource->bio,
            'image'    => $this->resource->image,
            'token'    => Jwt\Generator::token($this->resource),
            'role'     => $this->resource->getRoleNames(),
        ];
    }
}