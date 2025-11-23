<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')
    ->group(function (): void {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::resource('/profiles', ProfileController::class);

        Route::post('/courses/{course}/comments', [CommentController::class, 'storeCourseComment'])->name('courses.comments.store');
        Route::post('/lessons/{lesson}/comments', [CommentController::class, 'storeLessonComment'])->name('lessons.comments.store');
        Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
        Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    });
