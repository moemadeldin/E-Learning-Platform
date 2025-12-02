<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\Pagination;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\View\View;

final class MyCoursesController extends Controller
{
    public function __invoke(#[CurrentUser()] User $user): View
    {
        if ($user->isTeacher()) {

            $teachingCourses = $user->courses()
                ->with(['category'])
                ->withCount(['lessons', 'enrollments'])
                ->latest()
                ->paginate(Pagination::DEFAULT_PER_PAGE->value, ['*'], 'teaching_page');

            $enrolledCourses = $user->enrolledCourses()
                ->whereHas('teacher', function ($query) use ($user) {
                    $query->where('id', '!=', $user->id);
                })
                ->with(['category', 'teacher.profile'])
                ->withCount('lessons')
                ->latest('enrollments.created_at')
                ->paginate(Pagination::DEFAULT_PER_PAGE->value, ['*'], 'learning_page');

            return view('pages.my-courses', compact('teachingCourses', 'enrolledCourses'));
        }

        $enrolledCourses = $user->enrolledCourses()
            ->with(['category', 'teacher.profile'])
            ->withCount('lessons')
            ->latest('enrollments.created_at')
            ->paginate(Pagination::DEFAULT_PER_PAGE->value);

        return view('pages.my-courses', compact('enrolledCourses'));

    }
}
