<?php

declare(strict_types=1);

namespace App\Http\Requests\Teacher;

use App\Models\Course;
use App\Models\Section;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Container\Attributes\RouteParameter;
use Illuminate\Foundation\Http\FormRequest;

final class StoreSectionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(
        #[CurrentUser()] User $user,
        #[RouteParameter('course')] Course $course
    ): bool {
        return $course->teacher()->is($user);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string'],
            'order' => ['required', 'integer'],
        ];
    }

    public function prepareForValidation(): void
    {
        if (! $this->has('order')) {
            $lastSection = Section::where('course_id', $this->course_id)
                ->orderBy('order', 'desc')
                ->first();

            $this->merge([
                'order' => $lastSection ? $lastSection->order + 1 : 0,
            ]);
        }
    }
}
