<?php

declare(strict_types=1);

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')
    ->group(function (): void {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::resource('/profiles', ProfileController::class);
    });
