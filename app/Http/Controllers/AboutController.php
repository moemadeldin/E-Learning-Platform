<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\View\View;

final class AboutController extends Controller
{
    public function __invoke(): View
    {
        return view('pages.about', [
            'studentsCount' => User::activeStudents()->count(),
            'teachersCount' => User::activeTeachers()->count(),
            'coursesCount' => Course::count(),
            'teachers' => Teacher::with('user.profile')
                ->where('is_approved', true)
                ->limit(3)
                ->get(),
        ]);
    }
}
