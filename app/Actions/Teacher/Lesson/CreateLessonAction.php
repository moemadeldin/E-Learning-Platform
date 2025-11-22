<?php

declare(strict_types=1);

namespace App\Actions\Teacher\Lesson;

use App\Enums\LessonType;
use App\Models\Lesson;
use App\Models\Section;
use Illuminate\Support\Facades\DB;

final class CreateLessonAction
{
    public function execute(array $data, Section $section): Lesson
    {
        return DB::transaction(function () use ($data, $section): Lesson {
            $lesson = $section->lessons()->create($data);

            if (array_key_exists('attachments', $data) && is_array($data['attachments']) && count($data['attachments']) > 0) {
                foreach ($data['attachments'] as $attachment) {
                    $path = $attachment->store('lesson-attachments', 'public');

                    $lessonType = $this->mapMimeTypeToLessonType($attachment->getMimeType());

                    $lesson->attachments()->create([
                        'name' => $attachment->getClientOriginalName(),
                        'type' => $lessonType,
                        'url' => $path,
                        'size' => $attachment->getSize(),
                    ]);
                }
            }

            return $lesson;
        });
    }

    private function mapMimeTypeToLessonType(string $mimeType): LessonType
    {
        return match ($mimeType) {
            // Video
            'video/mp4', 'video/mpeg', 'video/ogg', 'video/webm', 'video/avi', 'video/mov', 'video/wmv', 'video/flv' => LessonType::VIDEO,

            // PDF
            'application/pdf' => LessonType::PDF,

            // Images
            'image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml', 'image/bmp' => LessonType::IMAGE,

            // Documents
            'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            'text/plain', 'text/csv', 'application/rtf', 'application/vnd.oasis.opendocument.text' => LessonType::DOCUMENT,

            // Audio
            'audio/mpeg', 'audio/wav', 'audio/ogg', 'audio/aac', 'audio/flac' => LessonType::AUDIO,

            default => LessonType::DOCUMENT,
        };
    }
}
