<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class UpdateProfileRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['nullable', 'email', 'unique:users,email,'.auth()->id()],
            'national_id' => ['nullable', 'digits:14', 'unique:teachers,national_id,'.auth()->user()->teacher->id],
            'avatar' => ['nullable', 'image', 'mimes:png,jpg'],
            'bio' => ['nullable', 'string'],
        ];
    }
}
