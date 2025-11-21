<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\LessonType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

final class LessonAttachment extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }

    protected function casts(): array
    {
        return [
            'lesson_id' => 'integer',
            'name' => 'string',
            'type' => LessonType::class,
            'url' => 'string',
            'size' => 'string',
        ];
    }
}
