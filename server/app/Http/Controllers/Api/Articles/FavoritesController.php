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

        $this->logFavoriteAction($request, $article, 'add');

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

        $this->logFavoriteAction($request, $article, 'remove');

        return new ArticleResource($article);
    }

    private function logFavoriteAction(Request $request, Article $article, string $action): void
    {
        $user_id = $request->user()->id;
        $article_id = $article->id;
        $actionMessage = 'add' === $action ? 'adicionou aos favoritos' : 'retirou dos favoritos';
        activity('FavoriteAction')
            ->performedOn($article)
            ->causedBy($request->user())
            ->event($action)
            ->withProperties([
                'user_id'    => $user_id,
                'article_id' => $article_id,
            ])
            ->log("Usuário de id: '{$user_id}' {$actionMessage} o artigo de id: '{$article_id}'");
    }
}
