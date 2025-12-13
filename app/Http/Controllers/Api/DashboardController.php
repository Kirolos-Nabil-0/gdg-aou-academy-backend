<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Certificate;
use App\Repositories\Interfaces\EnrollmentRepositoryInterface;
use App\Repositories\Interfaces\AttendanceRepositoryInterface;
use App\Repositories\Interfaces\GradeRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Dashboard Controller
 * 
 * Handles dashboard statistics and reporting
 */
class DashboardController extends Controller
{
    protected $enrollmentRepository;
    protected $attendanceRepository;
    protected $gradeRepository;

    public function __construct(
        EnrollmentRepositoryInterface $enrollmentRepository,
        AttendanceRepositoryInterface $attendanceRepository,
        GradeRepositoryInterface $gradeRepository
    ) {
        $this->enrollmentRepository = $enrollmentRepository;
        $this->attendanceRepository = $attendanceRepository;
        $this->gradeRepository = $gradeRepository;
    }

    /**
     * Admin Dashboard - Platform Overview
     * 
     * @return JsonResponse
     */
    public function adminDashboard(): JsonResponse
    {
        $stats = [
            'users' => [
                'total' => User::count(),
                'admins' => User::role('Admin')->count(),
                'instructors' => User::role('Instructor')->count(),
                'hr' => User::role('HR')->count(),
                'learners' => User::role('Learner')->count(),
            ],
            'courses' => [
                'total' => Course::count(),
                'published' => Course::where('status', 'published')->count(),
                'draft' => Course::where('status', 'draft')->count(),
                'archived' => Course::where('status', 'archived')->count(),
            ],
            'enrollments' => [
                'total' => Enrollment::count(),
                'active' => Enrollment::where('status', 'enrolled')->count(),
                'completed' => Enrollment::where('status', 'completed')->count(),
                'waitlisted' => Enrollment::where('status', 'waitlisted')->count(),
            ],
            'certificates' => [
                'total' => Certificate::count(),
                'issued' => Certificate::where('status', 'issued')->count(),
            ],
        ];

        return $this->successResponse($stats, __('messages.dashboard.retrieved_successfully'));
    }

    /**
     * Instructor/HR Dashboard - Course Management
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function instructorDashboard(Request $request): JsonResponse
    {
        $userId = $request->user()->id;

        // Get courses taught by this instructor
        $courses = Course::where('instructor_id', $userId)
            ->with(['track'])
            ->get();

        $courseStats = [];
        foreach ($courses as $course) {
            $enrollments = $this->enrollmentRepository->getCourseEnrollments($course->id);

            $courseStats[] = [
                'course_id' => $course->id,
                'course_name' => $course->title,
                'track' => $course->track->name ?? null,
                'total_enrollments' => $enrollments->count(),
                'active_enrollments' => $enrollments->where('status', 'enrolled')->count(),
                'capacity' => $course->capacity,
                'status' => $course->status,
            ];
        }

        $stats = [
            'total_courses' => $courses->count(),
            'courses' => $courseStats,
        ];

        return $this->successResponse($stats, __('messages.dashboard.retrieved_successfully'));
    }

    /**
     * Learner Dashboard - My Progress
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function learnerDashboard(Request $request): JsonResponse
    {
        $userId = $request->user()->id;

        // Get user enrollments
        $enrollments = $this->enrollmentRepository->getUserEnrollments($userId);

        $courseProgress = [];
        foreach ($enrollments as $enrollment) {
            $courseId = $enrollment->course_id;

            // Calculate attendance and grade
            $attendancePercentage = $this->attendanceRepository->calculateAttendancePercentage($userId, $courseId);
            $finalGrade = $this->gradeRepository->calculateFinalGrade($userId, $courseId);

            $courseProgress[] = [
                'course_id' => $courseId,
                'course_name' => $enrollment->course->title ?? null,
                'track' => $enrollment->course->track->name ?? null,
                'enrollment_status' => $enrollment->status,
                'enrolled_at' => $enrollment->enrolled_at,
                'attendance_percentage' => $attendancePercentage,
                'final_grade' => $finalGrade,
                'eligible_for_certificate' => $attendancePercentage >= 75 && $finalGrade >= 60,
            ];
        }

        $stats = [
            'total_enrollments' => $enrollments->count(),
            'active_courses' => $enrollments->where('status', 'enrolled')->count(),
            'completed_courses' => $enrollments->where('status', 'completed')->count(),
            'courses' => $courseProgress,
        ];

        return $this->successResponse($stats, __('messages.dashboard.retrieved_successfully'));
    }

    /**
     * Course Statistics (Instructor/HR/Admin)
     * 
     * @param int $courseId
     * @return JsonResponse
     */
    public function courseStatistics(int $courseId): JsonResponse
    {
        $course = Course::with(['track'])->find($courseId);

        if (!$course) {
            return $this->notFoundResponse(__('messages.course.not_found'));
        }

        $enrollments = $this->enrollmentRepository->getCourseEnrollments($courseId);

        // Calculate average attendance and grade
        $totalAttendance = 0;
        $totalGrade = 0;
        $count = 0;

        foreach ($enrollments as $enrollment) {
            $attendance = $this->attendanceRepository->calculateAttendancePercentage($enrollment->user_id, $courseId);
            $grade = $this->gradeRepository->calculateFinalGrade($enrollment->user_id, $courseId);

            $totalAttendance += $attendance;
            $totalGrade += $grade;
            $count++;
        }

        $stats = [
            'course' => [
                'id' => $course->id,
                'title' => $course->title,
                'track' => $course->track->name ?? null,
                'instructor' => $course->instructor->full_name ?? null,
            ],
            'enrollments' => [
                'total' => $enrollments->count(),
                'active' => $enrollments->where('status', 'enrolled')->count(),
                'completed' => $enrollments->where('status', 'completed')->count(),
                'capacity' => $course->capacity,
            ],
            'averages' => [
                'attendance' => $count > 0 ? round($totalAttendance / $count, 2) : 0,
                'grade' => $count > 0 ? round($totalGrade / $count, 2) : 0,
            ],
        ];

        return $this->successResponse($stats, __('messages.dashboard.retrieved_successfully'));
    }
}
