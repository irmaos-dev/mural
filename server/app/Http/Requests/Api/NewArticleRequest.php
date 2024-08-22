<?php

namespace App\Http\Requests\Api;

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
        return [
            'title' => ['required'],
            'slug' => ['required'],
            'description' => ['required'],
            'body' => ['required'],
            'tagList' => 'sometimes|array',
            'tagList.*' => 'required|string|max:255',
        ];
    }
}
