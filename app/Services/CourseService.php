<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\Admin\CourseDTO;
use App\Enums\Pagination;
use App\Interfaces\CourseServiceInterface;
use App\Models\Category;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

final class CourseService implements CourseServiceInterface
{
    public function getCoursesList(?User $user, array $filters = []): array
    {
        $query = Course::query();

        if ($user && $user->isTeacher() && ! $user->isAdmin()) {
            $query->courseOwner($user);
        }
        $query->with([
            'teacher.profile',
            'teacher.teacher',
            'category',
        ]);
        $query->withCount('lessons');
        $query->filteredCourses($filters['is_free'] ?? null, $filters['slug'] ?? null);

        $courses = $query->paginate(Pagination::COURSES_PER_PAGE->value)->withQueryString();

        $categories = Category::getCategories()->get();

        return [
            'courses' => $courses,
            'categories' => $categories,
        ];
    }

    public function createCourse(UploadedFile $thumbnail, CourseDTO $dto): Course
    {
        return DB::transaction(function () use ($thumbnail, $dto): Course {
            $thumbnailPath = $thumbnail->store('thumbnails/'.Str::slug($dto->name), 'public');
            $course = array_merge(
                $dto->toArray(), [
                    'thumbnail' => $thumbnailPath,
                ]
            );

            if (! Auth::user()->isAdmin()) {
                $course['user_id'] = Auth::id();
            }

            return Course::create($course);
        });
    }

    public function updateCourse(UploadedFile $thumbnail, CourseDTO $dto, Course $course): Course
    {
        return DB::transaction(function () use ($thumbnail, $dto, $course): Course {
            $data = $dto->toArray();
            if ($thumbnail) {
                if ($course->thumbnail && Storage::disk('public')->exists($course->thumbnail)) {
                    Storage::disk('public')->delete($course->thumbnail);
                }
                $folderName = (string) str($data['name']);
                $data['thumbnail'] = $thumbnail->store("thumbnails/{$folderName}", 'public');
            }
            if (! Auth::user()->isAdmin()) {
                $data['user_id'] = Auth::id();
            }
            $course->update($data);

            return $course;
        });
    }
}
