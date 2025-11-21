<?php

declare(strict_types=1);

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Teacher\CourseController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:teacher'])
    ->prefix('dashboard/teacher')
    ->group(function (): void {
        Route::get('/', DashboardController::class)->name('dashboard');
        Route::resource('courses', CourseController::class)->names([
            'index' => 'dashboard.teacher.courses.index',
            'create' => 'dashboard.teacher.courses.create',
            'store' => 'dashboard.teacher.courses.store',
            'edit' => 'dashboard.teacher.courses.edit',
            'update' => 'dashboard.teacher.courses.update',
            'destroy' => 'dashboard.teacher.courses.destroy',
        ]);
    });
