<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Api\Articles;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\ArticleResource;
use App\Models\Article;
use Illuminate\Http\Request;

final class FavoritesController extends Controller
{
    /**
     * Add article to user's favorites.
     *
     * @param Request $request
     * @param string $slug
     * @return ArticleResource
     */
    public function add(Request $request, string $slug)
    {
        $article = Article::whereSlug($slug)
            ->firstOrFail();

        /** @var \App\Models\User $user */
        $user = $request->user();

        $user->favorites()->syncWithoutDetaching($article);

        return new ArticleResource($article);
    }

    /**
     * Remove article from user's favorites.
     *
     * @param Request $request
     * @param string $slug
     * @return ArticleResource
     */
    public function remove(Request $request, string $slug)
    {
        $article = Article::whereSlug($slug)
            ->firstOrFail();

        /** @var \App\Models\User $user */
        $user = $request->user();

        $user->favorites()->detach($article);

        return new ArticleResource($article);
    }
}
