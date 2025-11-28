<?php

declare(strict_types=1);

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Teacher\CourseController;
use App\Http\Controllers\Teacher\LessonController;
use App\Http\Controllers\Teacher\SectionController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:teacher'])
    ->prefix('dashboard/teacher')
    ->group(function (): void {
        Route::get('/', DashboardController::class)->name('dashboard.teacher');
        Route::resource('courses', CourseController::class)->names('dashboard.teacher.courses');
        Route::controller(SectionController::class)->group(function (): void {
            Route::post('/courses/{course}/sections', 'store')->name('sections.store');
            Route::get('/courses/{course}/sections/{section}/edit', 'edit')->name('sections.edit');
            Route::put('/courses/{course}/sections/{section}', 'update')->name('sections.update');
            Route::delete('/courses/{course}/sections/{section}', 'destroy')->name('sections.destroy');
        });
        Route::controller(LessonController::class)->group(function (): void {
            Route::get('/courses/{course}/sections/{section}/lessons/create', 'create')->name('lessons.create');
            Route::post('/sections/{section}/lessons/', 'store')->name('lessons.store');

            Route::put('/courses/{course}/sections/{section}/lessons/{lesson}', 'update')->name('lessons.update');
            Route::delete('/courses/{course}/sections/{section}/lessons/{lesson}', 'destroy')->name('lessons.destroy');
        });
    });
