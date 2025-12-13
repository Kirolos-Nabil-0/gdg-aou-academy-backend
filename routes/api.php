<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CollegeController;
use App\Http\Controllers\Api\TrackController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\EnrollmentController;
use App\Http\Controllers\Api\SessionController;
use App\Http\Controllers\Api\AttendanceController;
use App\Http\Controllers\Api\AssignmentController;
use App\Http\Controllers\Api\GradeController;
use App\Http\Controllers\Api\CertificateController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Authentication Routes (Public)
|--------------------------------------------------------------------------
| These routes are protected with strict rate limiting to prevent abuse
*/

Route::prefix('auth')->middleware('throttle:auth')->group(function () {
    // Registration
    Route::post('/register', [AuthController::class, 'register']);

    // Login
    Route::post('/login', [AuthController::class, 'login']);

    // Password Reset
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);
});

/*
|--------------------------------------------------------------------------
| Public Routes (Reference Data)
|--------------------------------------------------------------------------
| These routes are publicly accessible for reference data
*/

// Colleges - Public GET, Admin-only CUD
Route::get('/colleges', [CollegeController::class, 'index']);
Route::get('/colleges/{id}', [CollegeController::class, 'show']);

// Tracks - Public GET, Admin-only CUD
Route::get('/tracks', [TrackController::class, 'index']);
Route::get('/tracks/{id}', [TrackController::class, 'show']);

// Published Courses - Public access for browsing
Route::get('/courses/published', [CourseController::class, 'published']);

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
| These routes require authentication via Sanctum
*/

Route::middleware('auth:sanctum')->group(function () {

    // User Profile
    Route::get('/user/me', [AuthController::class, 'me']);

    // Logout
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::post('/auth/logout-all', [AuthController::class, 'logoutAll']);

    // Colleges - Admin-only CUD operations
    Route::middleware('role:Admin')->group(function () {
        Route::post('/colleges', [CollegeController::class, 'store']);
        Route::put('/colleges/{id}', [CollegeController::class, 'update']);
        Route::delete('/colleges/{id}', [CollegeController::class, 'destroy']);
    });

    // Tracks - Admin-only CUD operations
    Route::middleware('role:Admin')->group(function () {
        Route::post('/tracks', [TrackController::class, 'store']);
        Route::put('/tracks/{id}', [TrackController::class, 'update']);
        Route::delete('/tracks/{id}', [TrackController::class, 'destroy']);
    });

    // Courses - CRUD (Admin/Instructor only via Form Request authorization)
    Route::apiResource('courses', CourseController::class);

    // Enrollments - Grouped with prefix
    Route::prefix('enrollments')->group(function () {
        Route::post('/', [EnrollmentController::class, 'enroll']);
        Route::get('/my', [EnrollmentController::class, 'myEnrollments']);
        Route::get('/course/{courseId}', [EnrollmentController::class, 'courseEnrollments']);
        Route::delete('/course/{courseId}', [EnrollmentController::class, 'unenroll']);
    });

    // Sessions - Grouped with prefix
    Route::prefix('sessions')->group(function () {
        Route::get('/course/{courseId}', [SessionController::class, 'courseSessions']);
        Route::get('/course/{courseId}/upcoming', [SessionController::class, 'upcomingSessions']);
        Route::post('/', [SessionController::class, 'store']);
    });

    // Attendance - Grouped with prefix
    Route::prefix('attendance')->group(function () {
        Route::post('/mark', [AttendanceController::class, 'markAttendance']);
        Route::get('/session/{sessionId}', [AttendanceController::class, 'sessionAttendance']);
        Route::get('/course/{courseId}/my', [AttendanceController::class, 'myCourseAttendance']);
        Route::get('/user/{userId}/course/{courseId}', [AttendanceController::class, 'userAttendancePercentage']);
    });

    // Assignments - Grouped with prefix
    Route::prefix('assignments')->group(function () {
        Route::get('/course/{courseId}', [AssignmentController::class, 'courseAssignments']);
        Route::post('/', [AssignmentController::class, 'store']);
        Route::get('/{id}', [AssignmentController::class, 'show']);
        Route::put('/{id}', [AssignmentController::class, 'update']);
        Route::delete('/{id}', [AssignmentController::class, 'destroy']);
    });

    // Grades - Grouped with prefix
    Route::prefix('grades')->group(function () {
        Route::post('/submit', [GradeController::class, 'submitGrade']);
        Route::get('/assignment/{assignmentId}', [GradeController::class, 'assignmentGrades']);
        Route::get('/course/{courseId}/my', [GradeController::class, 'myCourseGrades']);
        Route::get('/course/{courseId}/gradebook', [GradeController::class, 'courseGradebook']);
        Route::get('/user/{userId}/course/{courseId}/final', [GradeController::class, 'userFinalGrade']);
    });

    // Certificates - Grouped with prefix
    Route::prefix('certificates')->group(function () {
        Route::post('/course/{courseId}/generate', [CertificateController::class, 'generate']);
        Route::get('/course/{courseId}/download', [CertificateController::class, 'download']);
        Route::get('/course/{courseId}/my', [CertificateController::class, 'myCertificate']);
        Route::get('/course/{courseId}/eligibility', [CertificateController::class, 'checkEligibility']);
    });

    // Dashboards - Grouped with prefix
    Route::prefix('dashboard')->group(function () {
        Route::get('/admin', [DashboardController::class, 'adminDashboard'])->middleware('role:Admin');
        Route::get('/instructor', [DashboardController::class, 'instructorDashboard'])->middleware('role:Instructor,HR');
        Route::get('/learner', [DashboardController::class, 'learnerDashboard']);
        Route::get('/course/{courseId}/statistics', [DashboardController::class, 'courseStatistics']);
    });

    // Notifications - Grouped with prefix
    Route::prefix('notifications')->group(function () {
        Route::get('/', [NotificationController::class, 'index']);
        Route::get('/unread', [NotificationController::class, 'unread']);
        Route::post('/{id}/read', [NotificationController::class, 'markAsRead']);
        Route::post('/read-all', [NotificationController::class, 'markAllAsRead']);
        Route::delete('/{id}', [NotificationController::class, 'destroy']);
    });

    // User Management - Admin only
    Route::prefix('users')->middleware('role:Admin')->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::post('/', [UserController::class, 'store']);
        Route::get('/{id}', [UserController::class, 'show']);
        Route::put('/{id}', [UserController::class, 'update']);
        Route::delete('/{id}', [UserController::class, 'destroy']);
        Route::post('/{id}/assign-role', [UserController::class, 'assignRole']);
    });

});