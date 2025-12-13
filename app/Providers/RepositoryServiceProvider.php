<?php

namespace App\Providers;

use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Eloquent\UserRepository;
use Illuminate\Support\ServiceProvider;

/**
 * Repository Service Provider
 * 
 * Binds repository interfaces to their implementations
 */
class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     * Bind repository interfaces to implementations
     */
    public function register(): void
    {
        // Bind UserRepository
        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );

        // Bind CollegeRepository
        $this->app->bind(
            \App\Repositories\Interfaces\CollegeRepositoryInterface::class,
            \App\Repositories\Eloquent\CollegeRepository::class
        );

        // Bind TrackRepository
        $this->app->bind(
            \App\Repositories\Interfaces\TrackRepositoryInterface::class,
            \App\Repositories\Eloquent\TrackRepository::class
        );

        // Bind CourseRepository
        $this->app->bind(
            \App\Repositories\Interfaces\CourseRepositoryInterface::class,
            \App\Repositories\Eloquent\CourseRepository::class
        );

        // Bind EnrollmentRepository
        $this->app->bind(
            \App\Repositories\Interfaces\EnrollmentRepositoryInterface::class,
            \App\Repositories\Eloquent\EnrollmentRepository::class
        );

        // Bind SessionRepository
        $this->app->bind(
            \App\Repositories\Interfaces\SessionRepositoryInterface::class,
            \App\Repositories\Eloquent\SessionRepository::class
        );

        // Bind AttendanceRepository
        $this->app->bind(
            \App\Repositories\Interfaces\AttendanceRepositoryInterface::class,
            \App\Repositories\Eloquent\AttendanceRepository::class
        );

        // Bind GradeRepository
        $this->app->bind(
            \App\Repositories\Interfaces\GradeRepositoryInterface::class,
            \App\Repositories\Eloquent\GradeRepository::class
        );

        // Bind AssignmentRepository
        $this->app->bind(
            \App\Repositories\Interfaces\AssignmentRepositoryInterface::class,
            \App\Repositories\Eloquent\AssignmentRepository::class
        );

        // Bind CertificateRepository
        $this->app->bind(
            \App\Repositories\Interfaces\CertificateRepositoryInterface::class,
            \App\Repositories\Eloquent\CertificateRepository::class
        );

        // Add more repository bindings here as needed
        // Example:
        // $this->app->bind(ModuleRepositoryInterface::class, ModuleRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
