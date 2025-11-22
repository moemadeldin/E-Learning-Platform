<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseCourseController;
use App\Http\Requests\Admin\CourseFilterRequest;
use App\Interfaces\CourseServiceInterface;
use App\Models\Category;
use App\Models\Course;
use App\Models\User;
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

        return view('dashboard.courses.index', [
            'courses' => $data['courses'],
            'categories' => $data['categories'],
        ]);
    }

    public function create(): View
    {
        $categories = Category::getCategoriesById()->get();
        if (Auth::user()->isAdmin()) {
            $teachers = User::query()
                ->activeTeachers()
                ->select('id', 'name')
                ->get();
        }

        return view('dashboard.courses.create', compact(['categories', 'teachers']));
    }

    public function show(Course $course): View
    {
        return view('dashboard.courses.show', compact('course'));
    }

    public function edit(Course $course): View
    {
        $categories = Category::getCategoriesById()->get();
        if (Auth::user()->isAdmin()) {
            $teachers = User::query()
                ->activeTeachers()
                ->select('id', 'name')
                ->get();
        }

        return view('dashboard.courses.update', compact(['course', 'categories', 'teachers']));
    }
}
