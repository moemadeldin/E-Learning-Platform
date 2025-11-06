<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\CourseLevel;
use App\Traits\Sluggable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

final class Course extends Model
{
    use Sluggable, SoftDeletes;

    private const NUMBER_OF_COURSES_FOR_HOME_PAGE = 3;

    protected $guarded = ['id'];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeGetCourses(Builder $query): Builder
    {
        return $query->with(['user', 'category'])->limit(self::NUMBER_OF_COURSES_FOR_HOME_PAGE);
    }

    public function scopeFilteredCourses(Builder $query, ?int $is_free, ?int $categoryId): Builder
    {
        return $query->with(['category', 'user.teacher'])
            ->filterIsFree($is_free)
            ->filterCategory($categoryId);
    }

    public function getFormattedPriceAttribute(): string
    {
        return $this->is_free || $this->price === null
        ? 'Free'
        : '$'.number_format($this->price, 2);
    }

    public function scopeCourseOwner(Builder $query, User $user): Builder
    {
        return $query->where('user_id', $user->id);
    }

    public function scopeFilterIsFree(Builder $query, string|int|null $status): Builder
    {
        if ($status === null || $status === '') {
            return $query;
        }

        if ($status === 1 || $status === '1') {
            return $query->where('is_free', true);
        }

        if ($status === 0 || $status === '0') {
            return $query->where('is_free', false);
        }

        return $query;
    }

    public function scopeFilterCategory(Builder $query, ?int $categoryId): Builder
    {
        if (! $categoryId) {
            return $query;
        }

        return $query->where('category_id', $categoryId);
    }

    public function getFormattedCreatedAtAttribute(): string
    {
        return Carbon::parse($this->created_at)->format('m/Y');
    }

    public function getUpperCaseLanguageAttribute(): string
    {
        return mb_strtoupper($this->language);
    }

    public function getCapitalizedTitleAttribute(): string
    {
        return ucwords($this->name);
    }

    public function getCapitalizedInstructorAttribute(): string
    {
        return ucwords($this->user->teacher->full_name);
    }

    protected function casts(): array
    {
        return [
            'price' => 'float',
            'is_free' => 'boolean',
            'level' => CourseLevel::class,
        ];
    }
}
