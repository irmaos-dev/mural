<?php

declare(strict_types = 1);

namespace App\Http\Requests\Api;

use App\Models\Article;
use Illuminate\Validation\Rule;

class NewArticleRequest extends BaseArticleRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $article = Article::whereSlug($this->route('slug'))->first();

        $unique = Rule::unique('articles', 'slug');

        if (null !== $article) {
            $unique->ignoreModel($article);
        }

        return [
            'title'       => ['required'],
            'slug'        => ['required', 'alpha_dash', $unique],
            'description' => ['required'],
            'body'        => ['required'],
            'tagList'     => 'sometimes|array',
            'tagList.*'   => 'required|string|max:255',
        ];
    }
}
