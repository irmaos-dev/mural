<?php

namespace App\Http\Requests\Api;

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
        return [
            'title' => ['required_without_all:description,body'],
            'slug' => ['required_with:title'],
            'description' => ['required_without_all:title,body'],
            'body' => ['required_without_all:title,description'],
        ];
    }
}
