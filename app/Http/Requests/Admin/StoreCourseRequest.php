<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use App\Enums\CourseLevel;
use App\Models\Course;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

final class StoreCourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', Course::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'thumbnail' => ['required', 'image', 'mimes:png,jpg,jpeg,webp', 'max:2048'],
            'description' => ['required', 'string', 'max:255'],
            'long_description' => ['required', 'string'],
            'price' => ['required_if:is_free,false', 'numeric'],
            'is_free' => ['required', 'boolean'],
            'level' => ['required', new Enum(CourseLevel::class)],
            'language' => ['required', 'string', 'size:2'],
            'category_id' => ['required', 'exists:categories,id'],
            'user_id' => [Rule::requiredIf(fn (): bool => Auth::user()->isAdmin()), 'exists:users,id'],
            'requirements' => ['required', 'array'],
            'requirements.*' => ['required', 'string']
        ];
    }
}
