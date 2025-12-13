<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Enrollment\EnrollRequest;
use App\Repositories\Interfaces\EnrollmentRepositoryInterface;
use App\Repositories\Interfaces\CourseRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Enrollment Controller
 * 
 * Handles enrollment-related API endpoints
 * Uses Repository pattern for data access
 */
class EnrollmentController extends Controller
{
    /**
     * @var EnrollmentRepositoryInterface
     */
    protected $enrollmentRepository;

    /**
     * @var CourseRepositoryInterface
     */
    protected $courseRepository;

    /**
     * EnrollmentController constructor
     * 
     * @param EnrollmentRepositoryInterface $enrollmentRepository
     * @param CourseRepositoryInterface $courseRepository
     */
    public function __construct(
        EnrollmentRepositoryInterface $enrollmentRepository,
        CourseRepositoryInterface $courseRepository
    ) {
        $this->enrollmentRepository = $enrollmentRepository;
        $this->courseRepository = $courseRepository;
    }

    /**
     * Enroll in a course (self-enrollment or manual by HR/Admin)
     * 
     * @param EnrollRequest $request
     * @return JsonResponse
     */
    public function enroll(EnrollRequest $request): JsonResponse
    {
        try {
            $courseId = $request->course_id;
            $userId = $request->user()->id;
            $enrolledBy = $request->has('user_id') ? $request->user()->id : null;

            // Check if already enrolled
            if ($this->enrollmentRepository->isEnrolled($userId, $courseId)) {
                return $this->errorResponse(__('messages.enrollment.already_enrolled'), 400);
            }

            // Check course capacity
            $course = $this->courseRepository->find($courseId);
            if (!$course) {
                return $this->notFoundResponse(__('messages.course.not_found'));
            }

            if (!$course->is_enrollable) {
                return $this->errorResponse(__('messages.enrollment.not_enrollable'), 400);
            }

            $currentEnrollments = $this->enrollmentRepository->getCourseEnrollments($courseId)->count();
            if ($course->capacity && $currentEnrollments >= $course->capacity) {
                return $this->errorResponse(__('messages.enrollment.course_full'), 400);
            }

            // Enroll user
            $enrollment = $this->enrollmentRepository->enrollUser($userId, $courseId, $enrolledBy);

            return $this->createdResponse($enrollment, __('messages.enrollment.enrolled_successfully'));
        } catch (\Exception $e) {
            return $this->errorResponse(__('messages.enrollment.enrollment_failed') . ': ' . $e->getMessage(), 500);
        }
    }

    /**
     * Get user's enrollments
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function myEnrollments(Request $request): JsonResponse
    {
        $enrollments = $this->enrollmentRepository->getUserEnrollments($request->user()->id);

        return $this->successResponse($enrollments, __('messages.enrollment.retrieved_successfully'));
    }

    /**
     * Get course enrollments (Admin/Instructor/HR only)
     * 
     * @param int $courseId
     * @return JsonResponse
     */
    public function courseEnrollments(int $courseId): JsonResponse
    {
        $enrollments = $this->enrollmentRepository->getCourseEnrollments($courseId);

        return $this->successResponse($enrollments, __('messages.enrollment.retrieved_successfully'));
    }

    /**
     * Unenroll from a course
     * 
     * @param int $courseId
     * @param Request $request
     * @return JsonResponse
     */
    public function unenroll(int $courseId, Request $request): JsonResponse
    {
        try {
            $userId = $request->user()->id;

            if (!$this->enrollmentRepository->isEnrolled($userId, $courseId)) {
                return $this->errorResponse(__('messages.enrollment.not_enrolled'), 400);
            }

            $this->enrollmentRepository->unenrollUser($userId, $courseId);

            return $this->successResponse(null, __('messages.enrollment.unenrolled_successfully'));
        } catch (\Exception $e) {
            return $this->errorResponse(__('messages.enrollment.unenroll_failed') . ': ' . $e->getMessage(), 500);
        }
    }
}
