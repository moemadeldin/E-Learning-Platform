<?php

declare(strict_types=1);

namespace App\Http\Controllers\Teacher;

use App\Actions\Teacher\Section\CreateSectionAction;
use App\Actions\Teacher\Section\DeleteSectionAction;
use App\Actions\Teacher\Section\UpdateSectionAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Teacher\StoreSectionRequest;
use App\Http\Requests\Teacher\UpdateSectionRequest;
use App\Models\Course;
use App\Models\Section;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

final class SectionController extends Controller
{
    public function index(Course $course, Section $section): View
    {
        return view('dashboard.Teacher.courses.show', compact(['course', 'section']));
    }

    public function store(StoreSectionRequest $request, Course $course, CreateSectionAction $action): RedirectResponse
    {
        $action->execute($request->validated(), $course);

        return redirect()->back();

    }

    public function edit(Course $course, Section $section): View
    {
        return view('dashboard.Teacher.courses.sections.update', compact(['course', 'section']));
    }

    public function update(UpdateSectionRequest $request, Course $course, Section $section, UpdateSectionAction $action): RedirectResponse
    {
        $this->authorize('update', $course);
        $action->execute($request->validated(), $section);

        return redirect()->back();
    }

    public function destroy(Course $course, Section $section, DeleteSectionAction $action): RedirectResponse
    {
        $this->authorize('delete', $course);

        $action->execute($section);

        return redirect()->back();
    }
}
