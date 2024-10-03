<?php

declare(strict_types = 1);

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;

final class LoginRequest extends FormRequest
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
            'email'    => 'required|string|email',
            'password' => 'required|string',
        ];
    }

    /**
     * @return array<mixed>
     */
    public function validationData(): array
    {
        return Arr::wrap($this->input('user'));
    }
}
