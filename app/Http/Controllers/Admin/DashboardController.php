<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\View\View;

final class DashboardController extends Controller
{
    public function __invoke(#[CurrentUser] User $user): View
    {
        if ($user->isTeacher()) {
            return view('dashboard.layout');
        }

        $users = User::activeUsersCount()->count();
        $teachers = User::activeTeachers()->count();
        $courses = Course::count();
        $teacherRequests = Teacher::teacherWithRequests()->count();

        return view('dashboard.analytics', [
            'users' => $users,
            'teachers' => $teachers,
            'courses' => $courses,
            'teacherRequests' => $teacherRequests,
        ]);
    }
}
