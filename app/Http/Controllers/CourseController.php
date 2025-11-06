<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Admin\CourseFilterRequest;
use App\Interfaces\CourseServiceInterface;
use App\Models\Course;
use Illuminate\View\View;

final class CourseController extends Controller
{
    public function __construct(private readonly CourseServiceInterface $courseService) {}

    public function index(CourseFilterRequest $request)
    {
        $data = $this->courseService->getCoursesList(null, $request->filters());

        return view('pages.courses', [
            'courses' => $data['courses'],
            'categories' => $data['categories'],
        ]);
    }

    public function show(Course $course): View
    {
        return view('pages.course', compact('course'));
    }
}
