<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use App\Enums\CourseLevel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

final class UpdateCourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('course'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['nullable', 'string'],
            'thumbnail' => ['nullable', 'image', 'mimes:png,jpg,jpeg,webp', 'max:2048'],
            'description' => ['nullable', 'string', 'max:255'],
            'long_description' => ['nullable', 'string'],
            'price' => ['nullable', 'numeric'],
            'is_free' => ['nullable', 'boolean'],
            'level' => ['nullable', new Enum(CourseLevel::class)],
            'language' => ['nullable', 'string', 'size:2'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'user_id' => ['nullable', 'exists:users,id'],
            'requirements' => ['nullable', 'array'],
            'requirements.*' => ['required', 'string'],
        ];
    }
}
