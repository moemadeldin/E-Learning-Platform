<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

final class Comment extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function parentComment(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_comment_id');
    }

    public function replies(): HasMany
    {
        return $this->hasMany(self::class, 'parent_comment_id');
    }

    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'user_id' => 'integer',
            'parent_comment_id' => 'integer',
            'comment' => 'text',
        ];
    }
}
