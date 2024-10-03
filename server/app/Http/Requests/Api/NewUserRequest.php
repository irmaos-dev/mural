<?php

declare(strict_types = 1);

namespace App\Http\Requests\Api;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rules\Password;

final class NewUserRequest extends FormRequest
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
            "username" => [
                "required",
                "string",
                "regex:" . User::REGEX_USERNAME,
                "max:255",
                "unique:users,username",
            ],
            "email"    => "required|string|email|max:255|unique:users,email",
            "password" => [
                "required",
                "string",
                "max:255",
                // we can set additional password requirements below
                Password::min(8),
            ],
            "bio"   => "sometimes|nullable|string",
            "image" => "sometimes|nullable|string|url",
        ];
    }

    /**
     * @return array<mixed>
     */
    public function validationData(): array
    {
        return Arr::wrap($this->input("user"));
    }
}
