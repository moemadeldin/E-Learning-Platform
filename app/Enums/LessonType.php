<?php

declare(strict_types=1);

namespace App\Enums;

enum LessonType: string
{
    case VIDEO = 'video';
    case PDF = 'pdf';
    case IMAGE = 'image';
    case AUDIO = 'audio';
    case DOCUMENT = 'document';

    public function label(): string
    {
        return match ($this) {
            self::VIDEO => 'Video',
            self::PDF => 'PDF',
            self::IMAGE => 'Image',
            self::AUDIO => 'Audio',
            self::DOCUMENT => 'Document',
        };
    }
}
