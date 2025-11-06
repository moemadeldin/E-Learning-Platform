<?php

declare(strict_types=1);

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordRecoveryController;
use App\Http\Controllers\TeacherRegistrationController;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest'])
    ->group(function (): void {
        Route::controller(AuthController::class)->group(function (): void {
            Route::get('/register', 'registerForm')->name('register');
            Route::get('/login', 'loginForm')->name('login');
        });
        Route::controller(TeacherRegistrationController::class)->group(function (): void {
            Route::get('/teacher-register', 'registerForm')->name('teacher.register');
        });
        Route::controller(PasswordRecoveryController::class)->group(function (): void {
            Route::get('/forgot-password', 'forgotPasswordForm')->name('forgot-password.get');
        });
    });
Route::middleware(['guest'])
    ->group(function (): void {
        Route::controller(AuthController::class)->group(function (): void {
            Route::post('/register', 'register')->name('register.post');
            Route::post('/login', 'login')->name('login.post');
        });
        Route::controller(TeacherRegistrationController::class)->group(function (): void {
            Route::post('/teacher-register', 'register')->name('teacher.register.post');
        });
        Route::controller(PasswordRecoveryController::class)->group(function (): void {
            Route::post('/forgot-password', 'forgotPassword')->name('forgot-password.post');
        });
    });
