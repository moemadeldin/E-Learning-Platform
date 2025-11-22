<?php

declare(strict_types=1);

namespace App\Actions\Teacher\Lesson;

use App\Models\Lesson;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

final class DeleteLessonAction
{
    public function execute(Lesson $lesson): void
    {
        DB::transaction(function () use ($lesson): void {
            if ($lesson->attachments->count() > 0) {
                foreach ($lesson->attachments as $attachment) {
                    Storage::disk('public')->delete($attachment->url);

                    $attachment->delete();
                }
            }
            $lesson->delete();
        });
    }
}
