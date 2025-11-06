<?php

declare(strict_types=1);

namespace App\Interfaces;

use App\DTOs\Admin\CourseDTO;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\UploadedFile;

interface CourseServiceInterface
{
    public function getCoursesList(?User $user, array $filters = []): array;

    public function createCourse(UploadedFile $thumbnail, CourseDTO $dto): Course;

    public function updateCourse(UploadedFile $thumbnail, CourseDTO $dto, Course $course): Course;
}
