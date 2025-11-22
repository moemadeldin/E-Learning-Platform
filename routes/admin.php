<?php

declare(strict_types=1);

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TeacherRegistrationAdminController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:admin'])
    ->prefix('dashboard')
    ->group(function (): void {
        Route::get('/', DashboardController::class)->name('dashboard');
        Route::resource('users', UserController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('courses', CourseController::class)->names('dashboard.courses');
        Route::get('/teachers-requests', [TeacherRegistrationAdminController::class, 'index'])->name('teachers.requests.index');
        Route::put('/teachers-requests/{teacher}', [TeacherRegistrationAdminController::class, 'accept'])->name('teachers.requests.accept');
        Route::delete('/teachers-requests/{teacher}', [TeacherRegistrationAdminController::class, 'reject'])->name('teachers.requests.reject');
    });
