<?php

declare(strict_types = 1);

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * Class ArticlesCollection
 *
 * @package App\Http\Resources
 * @property \Illuminate\Support\Collection<\App\Models\Article> $collection
 */
final class ArticlesCollection extends ResourceCollection
{
    /**
     * The "data" wrapper that should be applied.
     *
     * @var string|null
     */
    public static $wrap = 'articles';

    /**
     * The resource that this resource collects.
     *
     * @var string
     */
    public $collects = ArticleResource::class;

    /**
     * Get additional data that should be returned with the resource array.
     *
     * @param  Request  $request
     * @return array<string, mixed>
     */
    public function with(Request $request): array
    {
        return [
            'articlesCount' => $this->collection->count(),
        ];
    }
}
