<?php

declare(strict_types = 1);

namespace App\Http\Requests\Api;

class ArticleListRequest extends FeedRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'limit'     => 'sometimes|integer|min:1',
            'offset'    => 'sometimes|integer|min:0',
            'tag'       => 'sometimes|string',
            'author'    => 'sometimes|string',
            'favorited' => 'sometimes|string',
        ];
    }
}
