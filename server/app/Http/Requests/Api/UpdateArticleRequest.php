<?php

declare(strict_types = 1);

namespace App\Http\Requests\Api;
use App\Models\Article;
use Illuminate\Validation\Rule;

class UpdateArticleRequest extends BaseArticleRequest
{
    private mixed $id;

    public function rules(): array
    {
        $article = Article::whereSlug($this->route('slug'))->first();

        $unique = Rule::unique('articles', 'slug');

        if (null !== $article) {
            $unique->ignoreModel($article);
        }

        return [

            'title'       => ['required_without_all:description,body'],
            'slug'        => ['required_with:title', 'alpha_dash', $unique],
            'description' => ['required_without_all:title,body'],
            'body'        => ['required_without_all:title,description'],
        ];
    }
}
