<?php

declare(strict_types=1);

namespace App\Http\Requests\Teacher;

use Illuminate\Foundation\Http\FormRequest;

final class UpdateLessonRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['nullable', 'string'],
            'content' => ['nullable', 'string'],
            'order' => ['nullable', 'integer'],
            'attachments' => ['nullable', 'array'],
            'attachment.*' => ['file', 'mimes:jpg,jpeg,png,gif,webp,svg,bmp,mp4,mov,avi,mkv,wmv,flv,mp3,wav,aac,ogg,flac,pdf,doc,docx,xls,xlsx,ppt,pptx,txt,csv,rtf,odt'],
        ];
    }
}
