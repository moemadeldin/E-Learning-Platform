<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

final class Lesson extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }
    public function attachments(): HasMany
    {
        return $this->hasMany(LessonAttachment::class);
    }

    protected function casts(): array
    {
        return [
            'section_id' => 'integer',
            'title' => 'string',
            'content' => 'text',
            'order' => 'integer'
        ];
    }
}
