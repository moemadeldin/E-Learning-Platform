<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\CourseLevel;
use App\Enums\LessonType;
use App\Traits\Sluggable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphMany;
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

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeGetCourses(Builder $query): Builder
    {
        return $query->select(['id', 'name', 'slug', 'thumbnail', 'category_id', 'user_id', 'level', 'price'])
            ->with(['teacher:id,name', 'teacher.profile', 'category:id,name,slug'])
            ->limit(self::NUMBER_OF_COURSES_FOR_HOME_PAGE);
    }

    public function scopeFilteredCourses(Builder $query, ?int $is_free, ?string $categorySlug): Builder
    {
        return $query->with(['category', 'teacher.teacher'])
            ->filterIsFree($is_free)
            ->filterCategory($categorySlug);
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

    public function scopeFilterCategory(Builder $query, ?string $categorySlug): Builder
    {
        if (! $categorySlug) {
            return $query;
        }

        return $query->whereHas('category', function (Builder $q) use ($categorySlug): void {
            $q->where('slug', $categorySlug);
        });
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
        return ucwords($this->teacher->profile->full_name);
    }

    public function sections(): HasMany
    {
        return $this->hasMany(Section::class)->orderBy('order');
    }

    public function lessons(): HasManyThrough
    {
        return $this->hasManyThrough(Lesson::class, Section::class);
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'enrollments', 'course_id', 'student_id')
            ->withPivot(['enrolled_at', 'progress'])
            ->withTimestamps();
    }

    public function reviews(): MorphMany
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function getPdfAndDocumentAttachmentsAttribute(): int
    {
        $documentTypes = [
            LessonType::PDF,
            LessonType::DOCUMENT,
        ];

        if ($this->relationLoaded('sections') && $this->sections->contains(fn ($section): mixed => $section->relationLoaded('lessons'))) {
            return $this->sections
                ->flatMap->lessons
                ->flatMap->attachments
                ->whereIn('type', $documentTypes)
                ->count();
        }

        return $this->lessons()
            ->whereHas('attachments', function (Builder $query) use ($documentTypes): void {
                $query->whereIn('type', $documentTypes);
            })
            ->count();
    }

    protected function casts(): array
    {
        return [
            'user_id' => 'integer',
            'category_id' => 'integer',
            'slug' => 'string',
            'description' => 'string',
            'long_description' => 'string',
            'price' => 'float',
            'is_free' => 'boolean',
            'level' => CourseLevel::class,
            'requirements' => 'array',
        ];
    }
}
