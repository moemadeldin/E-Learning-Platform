<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

final class Teacher extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeIsApproved(Builder $query): Builder
    {
        return $query->where('is_approved', true);
    }

    public function scopeTeacherWithRequests(Builder $query): Builder
    {
        return $query->where('is_approved', false)->whereHas('user', function (Builder $q): void {
            $q->where('is_active', true);
        });
    }

    public function getFullNameAttribute(): string
    {
        return $this->first_name.' '.$this->last_name;
    }

    protected function casts(): array
    {
        return [
            'is_approved' => 'boolean',
            'is_active' => 'boolean',
            'hire_date' => 'datetime',
            'national_id' => 'string',
        ];
    }
}
