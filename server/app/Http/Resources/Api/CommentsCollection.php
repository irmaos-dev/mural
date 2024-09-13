<?php

declare(strict_types = 1);

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * Class CommentsCollection
 *
 * @package App\Http\Resources
 * @property \Illuminate\Support\Collection<\App\Models\Comment> $collection
 */
final class CommentsCollection extends ResourceCollection
{
    /**
     * The "data" wrapper that should be applied.
     *
     * @var string|null
     */
    public static $wrap = 'comments';

    /**
     * The resource that this resource collects.
     *
     * @var string
     */
    public $collects = CommentResource::class;
}
