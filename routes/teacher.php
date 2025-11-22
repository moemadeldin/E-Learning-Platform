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
        Route::get('/', DashboardController::class)->name('dashboard');
        // Route::resource('courses', CourseController::class)->names([
        //     'index' => 'dashboard.teacher.courses.index',
        //     'create' => 'dashboard.teacher.courses.create',
        //     'store' => 'dashboard.teacher.courses.store',
        //     'show' => 'dashboard.teacher.courses.show',
        //     'edit' => 'dashboard.teacher.courses.edit',
        //     'update' => 'dashboard.teacher.courses.update',
        //     'destroy' => 'dashboard.teacher.courses.destroy',
        // ]);
        Route::resource('courses', CourseController::class)->names('dashboard.teacher.courses');

        Route::post('/courses/{course}/sections', [SectionController::class, 'store'])->name('sections.store');
        Route::get('/courses/{course}/sections/{section}/edit', [SectionController::class, 'edit'])->name('sections.edit');
        Route::put('/courses/{course}/sections/{section}', [SectionController::class, 'update'])->name('sections.update');
        Route::delete('/courses/{course}/sections/{section}', [SectionController::class, 'destroy'])->name('sections.destroy');

        Route::get('/courses/{course}/sections/{section}/lessons/create', [LessonController::class, 'create'])->name('lessons.create');
        Route::post('/sections/{section}/lessons/', [LessonController::class, 'store'])->name('lessons.store');
        Route::get('/courses/{course}/sections/{section}/lessons/{lesson}', [LessonController::class, 'show'])->name('lessons.show');
        Route::put('/courses/{course}/sections/{section}/lessons/{lesson}', [LessonController::class, 'update'])->name('lessons.update');
        Route::delete('/courses/{course}/sections/{section}/lessons/{lesson}', [LessonController::class, 'destroy'])->name('lessons.destroy');
    });
