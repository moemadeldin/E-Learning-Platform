<?php

declare(strict_types=1);

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\BaseCourseController;
use App\Http\Requests\Admin\CourseFilterRequest;
use App\Interfaces\CourseServiceInterface;
use App\Models\Category;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

final class CourseController extends BaseCourseController
{
    public function __construct(private readonly CourseServiceInterface $courseService)
    {
        parent::__construct($courseService);
    }

    public function index(CourseFilterRequest $request): View
    {
        $data = $this->courseService->getCoursesList(Auth::user(), $request->filters());

        return view('dashboard.Teacher.courses.index', [
            'courses' => $data['courses'],
            'categories' => $data['categories'],
        ]);
    }

    public function show(Course $course): View
    {
        $course->load(['sections.lessons']);
        $course->loadCount('sections', 'lessons', 'students');

        return view('dashboard.Teacher.courses.show', compact('course'));
    }

    public function create(): View
    {
        $categories = Category::getCategoriesById()->get();

        return view('dashboard.Teacher.courses.create', compact(['categories']));
    }

    public function edit(Course $course): View
    {
        $categories = Category::getCategoriesById()->get();

        return view('dashboard.Teacher.courses.update', compact(['course', 'categories']));
    }
}
