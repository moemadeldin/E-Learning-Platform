<?php

declare(strict_types=1);

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PasswordRecoveryController;
use Illuminate\Support\Facades\Route;

foreach (['guest', 'admin', 'teacher'] as $file) {
    require __DIR__."/{$file}.php";
}

Route::middleware('auth')
    ->group(function (): void {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    });

Route::get('/reset-password', [PasswordRecoveryController::class, 'resetPasswordForm'])->name('reset-password.get');
Route::post('/reset-password', [PasswordRecoveryController::class, 'resetPassword'])->name('reset-password.post');

Route::get('/home', HomeController::class)->name('home');
Route::resource('/courses', CourseController::class);
Route::view('/about-us', 'pages.about')->name('about');
