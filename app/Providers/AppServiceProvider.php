<?php

declare(strict_types=1);

namespace App\Providers;

use App\Interfaces\AuthServiceInterface;
use App\Interfaces\CourseServiceInterface;
use App\Interfaces\ImageManagerInterface;
use App\Interfaces\PasswordRecoveryServiceInterface;
use App\Interfaces\TeacherRegistrationAdminServiceInterface;
use App\Interfaces\UserServiceInterface;
use App\Models\User;
use App\Services\AuthService;
use App\Services\CourseService;
use App\Services\ImageManager;
use App\Services\PasswordRecoveryService;
use App\Services\TeacherRegistrationAdminService;
use App\Services\UserService;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

final class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('access-admin-panel', function (User $user): bool {
            return $user->isAdmin();
        });
        $this->app->bind(
            AuthServiceInterface::class,
            AuthService::class
        );
        $this->app->bind(
            ImageManagerInterface::class,
            ImageManager::class
        );
        $this->app->bind(
            PasswordRecoveryServiceInterface::class,
            PasswordRecoveryService::class
        );
        $this->app->bind(
            CourseServiceInterface::class,
            CourseService::class
        );
        $this->app->bind(
            UserServiceInterface::class,
            UserService::class
        );
        $this->app->bind(
            TeacherRegistrationAdminServiceInterface::class,
            TeacherRegistrationAdminService::class
        );
    }
}
