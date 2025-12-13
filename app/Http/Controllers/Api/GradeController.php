<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Grade\SubmitGradeRequest;
use App\Repositories\Interfaces\GradeRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Grade Controller
 * 
 * Handles grading-related API endpoints
 * Uses Repository pattern for data access
 */
class GradeController extends Controller
{
    /**
     * @var GradeRepositoryInterface
     */
    protected $gradeRepository;

    /**
     * GradeController constructor
     * 
     * @param GradeRepositoryInterface $gradeRepository
     */
    public function __construct(GradeRepositoryInterface $gradeRepository)
    {
        $this->gradeRepository = $gradeRepository;
    }

    /**
     * Submit or update a grade (Instructor/Admin only)
     * 
     * @param SubmitGradeRequest $request
     * @return JsonResponse
     */
    public function submitGrade(SubmitGradeRequest $request): JsonResponse
    {
        try {
            $grade = $this->gradeRepository->submitGrade(
                $request->assignment_id,
                $request->user_id,
                $request->score,
                $request->user()->id,
                $request->feedback
            );

            return $this->successResponse($grade, __('messages.grade.submitted_successfully'));
        } catch (\Exception $e) {
            return $this->errorResponse(__('messages.grade.submission_failed') . ': ' . $e->getMessage(), 500);
        }
    }

    /**
     * Get grades for an assignment (Instructor/Admin only)
     * 
     * @param int $assignmentId
     * @return JsonResponse
     */
    public function assignmentGrades(int $assignmentId): JsonResponse
    {
        $grades = $this->gradeRepository->getAssignmentGrades($assignmentId);

        return $this->successResponse($grades, __('messages.grade.retrieved_successfully'));
    }

    /**
     * Get my grades for a course (Learner)
     * 
     * @param int $courseId
     * @param Request $request
     * @return JsonResponse
     */
    public function myCourseGrades(int $courseId, Request $request): JsonResponse
    {
        $grades = $this->gradeRepository->getUserCourseGrades($request->user()->id, $courseId);
        $finalGrade = $this->gradeRepository->calculateFinalGrade($request->user()->id, $courseId);

        return $this->successResponse([
            'grades' => $grades,
            'final_grade' => $finalGrade,
        ], __('messages.grade.retrieved_successfully'));
    }

    /**
     * Get gradebook for a course (Instructor/Admin only)
     * 
     * @param int $courseId
     * @return JsonResponse
     */
    public function courseGradebook(int $courseId): JsonResponse
    {
        // This would typically get all students enrolled in the course
        // and their grades, but for simplicity we'll return a message
        // In a real implementation, you'd query enrollments and calculate grades for each

        return $this->successResponse([
            'course_id' => $courseId,
            'message' => 'Gradebook endpoint - implement based on specific requirements'
        ], __('messages.grade.retrieved_successfully'));
    }

    /**
     * Get final grade for a user in a course
     * 
     * @param int $userId
     * @param int $courseId
     * @return JsonResponse
     */
    public function userFinalGrade(int $userId, int $courseId): JsonResponse
    {
        $finalGrade = $this->gradeRepository->calculateFinalGrade($userId, $courseId);

        return $this->successResponse([
            'user_id' => $userId,
            'course_id' => $courseId,
            'final_grade' => $finalGrade,
        ], __('messages.grade.retrieved_successfully'));
    }
}
