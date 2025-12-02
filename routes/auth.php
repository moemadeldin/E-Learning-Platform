<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FreeCourseClaimController;
use App\Http\Controllers\MyCoursesController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\Teacher\LessonController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')
    ->group(function (): void {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::resource('/profiles', ProfileController::class);
        Route::controller(CommentController::class)->group(function (): void {
            Route::post('/courses/{course}/comments', 'storeCourseComment')->name('courses.comments.store');
            Route::post('/lessons/{lesson}/comments', 'storeLessonComment')->name('lessons.comments.store');
            Route::put('/comments/{comment}', 'update')->name('comments.update');
            Route::delete('/comments/{comment}', 'destroy')->name('comments.destroy');
        });
        Route::get('/courses/{course}/sections/{section}/lessons/{lesson}', [LessonController::class, 'show'])->name('lessons.show');
        Route::controller(CartController::class)->group(function (): void {
            Route::get('/carts', 'index')->name('carts.index');
            Route::get('/carts/{course}', 'show')->name('carts.show');
            Route::post('/courses/{course}/add-to-cart', 'store')->name('carts.store');
            Route::delete('/carts/{cart}/courses/{course}', 'destroy')->name('carts.destroy');
        });
        Route::post('/courses/{course}', FreeCourseClaimController::class)->name('course.claim');

        Route::controller(StripeController::class)->group(function (): void {

            Route::post('/checkout/{course}', 'buyNow')->name('checkout.buy-now');
            Route::get('/checkout/single', 'singleCheckout')->name('checkout.single');
            Route::post('/stripe/create-single-session', 'createSingleCheckoutSession')->name('stripe.create-single-session');

            Route::get('/checkout', 'checkout')->name('checkout');
            Route::post('/stripe/create-session', 'createCheckoutSession')->name('stripe.create-session');
            Route::get('/stripe/success', 'success')->name('stripe.success');
        });

        Route::controller(ReviewController::class)->group(function (): void {
            Route::get('/reviews', 'index')->name('reviews.index');
            Route::get('/courses/{course}/reviews', 'edit')->name('reviews.edit');
            Route::post('/courses/{course}/reviews', 'store')->name('reviews.store');
            Route::patch('/reviews/{review}', 'update')->name('reviews.update');
            Route::delete('/reviews/{review}/', 'destroy')->name('reviews.destroy');
        });
        Route::get('/my-courses', MyCoursesController::class)->name('my-courses');
    });
