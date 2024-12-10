<?php

declare(strict_types = 1);

namespace App\Http\Requests\Api;

final class NewArticleRequest extends BaseArticleRequest
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
            'title'       => ['required'],
            'description' => ['required'],
            'body'        => ['required'],
            'tagList'     => 'sometimes|array',
            'tagList.*'   => 'required|string|max:255',
            'image'       => "sometimes|nullable|string|url",
        ];
    }
}
