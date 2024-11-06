<?php

declare(strict_types = 1);

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class ArticleResource
 *
 * @package App\Http\Resources
 * @property \App\Models\Article $resource
 */
final class ArticleResource extends JsonResource
{
    /**
     * The "data" wrapper that should be applied.
     *
     * @var string
     */
    public static $wrap = 'article';

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

        return [
            'slug'           => $this->resource->slug,
            'title'          => $this->resource->title,
            'description'    => $this->resource->description,
            'body'           => $this->resource->body,
            'tagList'        => new TagsCollection($this->resource->tags),
            'createdAt'      => $this->resource->created_at,
            'updatedAt'      => $this->resource->updated_at,
            'favorited'      => $user && $this->resource->favoredBy($user),
            'favoritesCount' => $this->resource->favoredUsers->count(),            'image' => $this->resource->image ?? "",
            'author'         => new ProfileResource($this->resource->author),
        ];
    }
}
