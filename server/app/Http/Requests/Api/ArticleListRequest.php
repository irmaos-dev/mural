<?php

declare(strict_types = 1);

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

final class ArticleListRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

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
