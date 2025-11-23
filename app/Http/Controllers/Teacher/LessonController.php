<?php

declare(strict_types=1);

namespace App\Http\Controllers\Teacher;

use App\Actions\Teacher\Lesson\CreateLessonAction;
use App\Actions\Teacher\Lesson\DeleteLessonAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Teacher\StoreLessonRequest;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Section;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

final class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index(Course $course, Section $section, Lesson $lesson): View
    // {
    //     $course->load(['sections.lessons']);
    //     return view('dashboard.Teacher.courses.show', compact(['course', 'section', 'lesson']));
    // }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Course $course, Section $section, Lesson $lesson): View
    {
        return view('dashboard.Teacher.courses.lessons.create', compact(['course', 'section', 'lesson']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLessonRequest $request, Section $section, CreateLessonAction $action): RedirectResponse
    {
        $action->execute($request->validated(), $section);

        return redirect()->route('dashboard.teacher.courses.index', $section->course)
            ->with('success', 'Lesson created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course, Section $section, Lesson $lesson): View
    {
        $course->load(['sections.lessons.attachments', 'category', 'comments.user.profile', 'comments.replies.user.profile']);
        $lesson->load(['attachments']);
        $section->load(['lessons']);

        $course->loadCount(['sections', 'lessons']);
        $lesson->loadCount('attachments');

        return view('dashboard.Teacher.courses.lessons.show', compact(['course', 'section', 'lesson']));
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(Course $course, Lesson $lesson)
    // {
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update(UpdateLessonRequest $request, Course $course, Lesson $lesson)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course, Lesson $lesson, DeleteLessonAction $action): RedirectResponse
    {
        $action->execute($lesson);

        return redirect()->back();
    }
}
