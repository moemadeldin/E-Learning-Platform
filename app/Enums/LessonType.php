<?php

declare(strict_types=1);

namespace App\Enums;

enum LessonType: string
{
    case VIDEO = 'video';
    case PDF = 'pdf';

    public function label(): string
    {
        return match ($this) {
            self::VIDEO => 'Video',
            self::PDF => 'PDF',
        };
    }
}
