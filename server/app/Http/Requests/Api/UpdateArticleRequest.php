<?php

namespace App\Http\Requests\Api;
use App\Models\Article;
use Illuminate\Validation\Rule;

class UpdateArticleRequest extends BaseArticleRequest
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
        $article = Article::whereSlug($this->route('slug'))
            ->first();

        $unique = Rule::unique('articles', 'slug');
        if ($article !== null) {
            $unique->ignoreModel($article);
        }

        return [
            'title' => ['required_without_all:description,body'],
            'slug' => ['required_with:title', $unique],
            'description' => ['required_without_all:title,body'],
            'body' => ['required_without_all:title,description'],
        ];
    }
}
