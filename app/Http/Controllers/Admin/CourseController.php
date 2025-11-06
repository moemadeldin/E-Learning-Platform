<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\DTOs\Admin\CourseDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CourseFilterRequest;
use App\Http\Requests\Admin\StoreCourseRequest;
use App\Http\Requests\Admin\UpdateCourseRequest;
use App\Interfaces\CourseServiceInterface;
use App\Models\Category;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

final class CourseController extends Controller
{
    public function __construct(private readonly CourseServiceInterface $courseService) {}

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

    public function store(StoreCourseRequest $request): RedirectResponse
    {
        $this->courseService->createCourse($request->file('thumbnail'), CourseDTO::fromArray($request->validated()));

        return redirect()->route('courses.index')->with('success', 'Course created successfully');

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

    public function update(UpdateCourseRequest $request, Course $course): RedirectResponse
    {
        $this->courseService->updateCourse($request->file('thumbnail'), CourseDTO::fromArray($request->validated()), $course);

        return redirect()->route('courses.index')->with('success', 'Course updated successfully');
    }

    public function destroy(Course $course): RedirectResponse
    {
        $this->authorize('delete', $course);
        $course->delete();

        return redirect()->route('courses.index')->with('success', 'Course deleted successfully');
    }
}
