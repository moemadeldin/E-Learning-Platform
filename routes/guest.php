<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\PasswordRecoveryController;
use App\Http\Controllers\Auth\TeacherRegistrationController;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest'])
    ->group(function (): void {
        Route::controller(AuthController::class)->group(function (): void {
            Route::get('/register', 'registerForm')->name('register');
            Route::post('/register', 'register')->name('register.post');
            Route::get('/login', 'loginForm')->name('login');
            Route::post('/login', 'login')->name('login.post');
        });
        Route::controller(TeacherRegistrationController::class)->group(function (): void {
            Route::get('/teacher-register', 'registerForm')->name('teacher.register.get');
            Route::post('/teacher-register', 'register')->name('teacher.register.post');
        });
        Route::controller(PasswordRecoveryController::class)->group(function (): void {
            Route::get('/forgot-password', 'forgotPasswordForm')->name('forgot-password.get');
            Route::post('/forgot-password', 'forgotPassword')->name('forgot-password.post');
            Route::get('/reset-password', 'resetPasswordForm')->name('reset-password.get');
            Route::post('/reset-password', 'resetPassword')->name('reset-password.post');
        });
    });
