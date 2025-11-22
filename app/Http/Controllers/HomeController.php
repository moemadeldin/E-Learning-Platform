<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

final class HomeController extends Controller
{
    public function __invoke(): View
    {
        $categories = Cache::remember('homepage_categories', 60 * 60, function () {
            return Category::select('name', 'slug')->get();
        });
        $courses = Course::getCourses()
            ->with('sections.lessons')
            ->withCount('lessons')
            ->whereNotNull('category_id')->get();

        return view('pages.home', compact(['categories', 'courses']));
    }
}
