<?php

declare(strict_types=1);

namespace App\Http\Requests\Teacher;

use App\Models\Lesson;
use Illuminate\Foundation\Http\FormRequest;

final class StoreLessonRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string'],
            'content' => ['required', 'string'],
            'order' => ['required', 'integer'],
            'attachments' => ['nullable', 'array'],
            'attachments.*' => ['file', 'mimes:jpg,jpeg,png,gif,webp,svg,bmp,mp4,mov,avi,mkv,wmv,flv,mp3,wav,aac,ogg,flac,pdf,doc,docx,xls,xlsx,ppt,pptx,txt,csv,rtf,odt'],
        ];
    }

    public function prepareForValidation(): void
    {
        if (! $this->has('order')) {
            $lastLesson = Lesson::where('course_id', $this->course_id)
                ->orderBy('order', 'desc')
                ->first();

            $this->merge([
                'order' => $lastLesson ? $lastLesson->order + 1 : 0,
            ]);
        }
    }
}
