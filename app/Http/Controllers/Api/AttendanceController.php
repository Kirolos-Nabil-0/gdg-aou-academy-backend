<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Attendance\MarkAttendanceRequest;
use App\Repositories\Interfaces\AttendanceRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Attendance Controller
 * 
 * Handles attendance-related API endpoints
 * Uses Repository pattern for data access
 */
class AttendanceController extends Controller
{
    /**
     * @var AttendanceRepositoryInterface
     */
    protected $attendanceRepository;

    /**
     * AttendanceController constructor
     * 
     * @param AttendanceRepositoryInterface $attendanceRepository
     */
    public function __construct(AttendanceRepositoryInterface $attendanceRepository)
    {
        $this->attendanceRepository = $attendanceRepository;
    }

    /**
     * Mark attendance for a session (Instructor/HR/Admin only)
     * 
     * @param MarkAttendanceRequest $request
     * @return JsonResponse
     */
    public function markAttendance(MarkAttendanceRequest $request): JsonResponse
    {
        try {
            $attendance = $this->attendanceRepository->markAttendance(
                $request->session_id,
                $request->user_id,
                $request->status,
                $request->user()->id
            );

            return $this->successResponse($attendance, __('messages.attendance.marked_successfully'));
        } catch (\Exception $e) {
            return $this->errorResponse(__('messages.attendance.marking_failed') . ': ' . $e->getMessage(), 500);
        }
    }

    /**
     * Get attendance for a session
     * 
     * @param int $sessionId
     * @return JsonResponse
     */
    public function sessionAttendance(int $sessionId): JsonResponse
    {
        $attendance = $this->attendanceRepository->getSessionAttendance($sessionId);

        return $this->successResponse($attendance, __('messages.attendance.retrieved_successfully'));
    }

    /**
     * Get user's attendance for a course
     * 
     * @param int $courseId
     * @param Request $request
     * @return JsonResponse
     */
    public function myCourseAttendance(int $courseId, Request $request): JsonResponse
    {
        $attendance = $this->attendanceRepository->getUserCourseAttendance($request->user()->id, $courseId);
        $percentage = $this->attendanceRepository->calculateAttendancePercentage($request->user()->id, $courseId);

        return $this->successResponse([
            'attendance' => $attendance,
            'percentage' => $percentage,
        ], __('messages.attendance.retrieved_successfully'));
    }

    /**
     * Get attendance percentage for a user in a course (Instructor/HR/Admin)
     * 
     * @param int $userId
     * @param int $courseId
     * @return JsonResponse
     */
    public function userAttendancePercentage(int $userId, int $courseId): JsonResponse
    {
        $percentage = $this->attendanceRepository->calculateAttendancePercentage($userId, $courseId);

        return $this->successResponse([
            'user_id' => $userId,
            'course_id' => $courseId,
            'percentage' => $percentage,
        ], __('messages.attendance.retrieved_successfully'));
    }
}
