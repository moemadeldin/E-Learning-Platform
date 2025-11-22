<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Admin\CourseFilterRequest;
use App\Interfaces\CourseServiceInterface;
use App\Models\Category;
use App\Models\Course;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

final class CourseController extends Controller
{
    public function __construct(private readonly CourseServiceInterface $courseService) {}

    public function index(CourseFilterRequest $request): View
    {
        $data = $this->courseService->getCoursesList(null, $request->filters());

        return view('pages.courses', [
            'courses' => $data['courses'],
            'categories' => $data['categories'],
        ]);
    }

    public function show(Course $course): View
    {
        $course->load([
            'sections.lessons.attachments',
            'teacher.profile',
            'teacher.teacher',
            'category',
            'reviews',
        ]);
        $course->loadCount([
            'reviews',
            'enrollments',
            'lessons',
            'sections',
        ]);
        $categories = Cache::remember('categories.'.Category::max('updated_at'), 3600, function (): Collection {
            return Category::getCategories()->get();
        });

        return view('pages.course', [
            'course' => $course,
            'categories' => $categories,
        ]);
    }
}
