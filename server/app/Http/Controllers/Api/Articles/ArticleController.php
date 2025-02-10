<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Api\Articles;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ArticleListRequest;
use App\Http\Requests\Api\FeedRequest;
use App\Http\Requests\Api\NewArticleRequest;
use App\Http\Requests\Api\UpdateArticleRequest;
use App\Http\Resources\Api\ArticleResource;
use App\Http\Resources\Api\ArticlesCollection;
use App\Models\Article;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

final class ArticleController extends Controller
{
    /** @var int Default limit for feed listing. */
    protected const FILTER_LIMIT = 20;

    /** @var int Default offset for feed listing. */
    protected const FILTER_OFFSET = 0;

    /**
     * Display global listing of the articles.
     *
     * @param ArticleListRequest $request
     * @return \App\Http\Resources\Api\ArticlesCollection<Article>
     */
    public function list(ArticleListRequest $request): ArticlesCollection
    {
        $filter = collect($request->validated());

        $limit = $this->getLimit($filter);
        $offset = $this->getOffset($filter);

        $list = Article::list($limit, $offset);

        if ($tag = $filter->get('tag')) {
            $list->havingTag($tag);
        }

        if ($authorName = $filter->get('author')) {
            $list->ofAuthor($authorName);
        }

        if ($userName = $filter->get('favorited')) {
            $list->favoredByUser($userName);
        }

        return new ArticlesCollection($list->get());
    }

    /**
     * Display article feed for the user.
     *
     * @param FeedRequest $request
     * @return \App\Http\Resources\Api\ArticlesCollection<Article>
     */
    public function feed(FeedRequest $request): ArticlesCollection
    {
        $filter = collect($request->validated());

        $limit = $this->getLimit($filter);
        $offset = $this->getOffset($filter);

        $feed = Article::list($limit, $offset)
            ->followedAuthorsOf($request->user());

        return new ArticlesCollection($feed->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param NewArticleRequest $request
     * @return JsonResponse
     */
    public function create(NewArticleRequest $request): JsonResponse
    {
        /** @var \App\Models\User $user */
        $user = $request->user();

        $attributes = $request->validated();
        $attributes['author_id'] = $user->getKey();

        $tags = Arr::pull($attributes, 'tagList');
        $article = Article::create($attributes);

        if (is_array($tags)) {
            $article->syncTags($tags);
        }

        return (new ArticleResource($article))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param string $slug
     * @return ArticleResource
     */
    public function show(string $slug): ArticleResource
    {
        $article = Article::whereSlug($slug)
            ->firstOrFail();

        return new ArticleResource($article);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateArticleRequest $request
     * @param string $slug
     * @return ArticleResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateArticleRequest $request, string $slug): ArticleResource
    {
        $article = Article::whereSlug($slug)
            ->firstOrFail();

        $this->authorize('update', $article);

        $attributes = $request->validated();

        $tags = Arr::pull($attributes, 'tagList');
        $article->update($request->validated());

        if (is_array($tags)) {
            if ($article->tagList !== $tags) {
                $article->syncTags($tags);
            }

        }

        return new ArticleResource($article);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $slug
     * @return JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function delete(string $slug): JsonResponse
    {
        $article = Article::whereSlug($slug)
            ->firstOrFail();

        $this->authorize('delete', $article);

        $article->delete(); // cascade

        return response()->json([
            'message' => trans('models.article.deleted'),
        ]);
    }

    /**
     * Get limit from filter.
     *
     * @param \Illuminate\Support\Collection<string, string> $filter
     * @return int
     */
    private function getLimit(Collection $filter): int
    {
        return (int) ($filter['limit'] ?? static::FILTER_LIMIT);
    }

    /**
     * Get offset from filter.
     *
     * @param \Illuminate\Support\Collection<string, string> $filter
     * @return int
     */
    private function getOffset(Collection $filter): int
    {
        return (int) ($filter['offset'] ?? static::FILTER_OFFSET);
    }
}
