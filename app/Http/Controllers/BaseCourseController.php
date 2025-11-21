<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\DTOs\Admin\CourseDTO;
use App\Http\Requests\Admin\StoreCourseRequest;
use App\Http\Requests\Admin\UpdateCourseRequest;
use App\Interfaces\CourseServiceInterface;
use App\Models\Course;
use Illuminate\Http\RedirectResponse;

abstract class BaseCourseController extends Controller
{
    public function __construct(private readonly CourseServiceInterface $courseService) {}

    final public function store(StoreCourseRequest $request): RedirectResponse
    {
        $this->courseService->createCourse($request->file('thumbnail'), CourseDTO::fromArray($request->validated()));

        return redirect()->route('courses.index')->with('success', 'Course created successfully');

    }

    final public function update(UpdateCourseRequest $request, Course $course): RedirectResponse
    {
        $this->courseService->updateCourse($request->file('thumbnail'), CourseDTO::fromArray($request->validated()), $course);

        return redirect()->route('courses.index')->with('success', 'Course updated successfully');
    }

    final public function destroy(Course $course): RedirectResponse
    {
        $this->authorize('delete', $course);
        $course->delete();

        return redirect()->route('courses.index')->with('success', 'Course deleted successfully');
    }
}
