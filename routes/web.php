<?php

declare(strict_types=1);

use App\Http\Controllers\CourseController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

foreach (['guest', 'admin', 'teacher', 'auth'] as $file) {
    require __DIR__."/{$file}.php";
}

Route::get('/home', HomeController::class)->name('home');
Route::resource('/courses', CourseController::class);
Route::view('/about-us', 'pages.about')->name('about');
