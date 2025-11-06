<?php

declare(strict_types=1);

use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:admin,teacher'])
    ->prefix('dashboard')
    ->group(function (): void {
        Route::get('/', DashboardController::class)->name('dashboard');
        Route::resource('courses', CourseController::class)->names([
            'index' => 'dashboard.courses.index',
            'create' => 'dashboard.courses.create',
            'store' => 'dashboard.courses.store',
            'show' => 'dashboard.courses.show',
            'edit' => 'dashboard.courses.edit',
            'update' => 'dashboard.courses.update',
            'destroy' => 'dashboard.courses.destroy',
        ]);
    });
