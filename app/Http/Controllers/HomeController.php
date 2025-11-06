<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use Illuminate\View\View;

final class HomeController extends Controller
{
    public function __invoke(): View
    {
        $categories = Category::select('id', 'name')->get();
        $courses = Course::getCourses()->get();

        return view('pages.home', compact(['categories', 'courses']));
    }
}
