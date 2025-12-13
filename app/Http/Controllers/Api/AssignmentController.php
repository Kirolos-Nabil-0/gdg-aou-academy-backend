<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Assignment\CreateAssignmentRequest;
use App\Http\Requests\Assignment\UpdateAssignmentRequest;
use App\Repositories\Interfaces\AssignmentRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Assignment Controller
 * 
 * Handles assignment-related API endpoints
 */
class AssignmentController extends Controller
{
    /**
     * @var AssignmentRepositoryInterface
     */
    protected $assignmentRepository;

    /**
     * AssignmentController constructor
     * 
     * @param AssignmentRepositoryInterface $assignmentRepository
     */
    public function __construct(AssignmentRepositoryInterface $assignmentRepository)
    {
        $this->assignmentRepository = $assignmentRepository;
    }

    /**
     * Get all assignments for a course
     * 
     * @param int $courseId
     * @return JsonResponse
     */
    public function courseAssignments(int $courseId): JsonResponse
    {
        $assignments = $this->assignmentRepository->getCourseAssignments($courseId);

        return $this->successResponse($assignments, 'Assignments retrieved successfully');
    }

    /**
     * Create a new assignment
     * 
     * @param CreateAssignmentRequest $request
     * @return JsonResponse
     */
    public function store(CreateAssignmentRequest $request): JsonResponse
    {
        try {
            $assignment = $this->assignmentRepository->create($request->validated());

            return $this->createdResponse($assignment, 'Assignment created successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Assignment creation failed: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Get a specific assignment with grades
     * 
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $assignment = $this->assignmentRepository->getAssignmentWithGrades($id);

        if (!$assignment) {
            return $this->notFoundResponse('Assignment not found');
        }

        return $this->successResponse($assignment, 'Assignment retrieved successfully');
    }

    /**
     * Update an assignment
     * 
     * @param UpdateAssignmentRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateAssignmentRequest $request, int $id): JsonResponse
    {
        try {
            $assignment = $this->assignmentRepository->find($id);

            if (!$assignment) {
                return $this->notFoundResponse('Assignment not found');
            }

            $updated = $this->assignmentRepository->update($id, $request->validated());

            return $this->successResponse($updated, 'Assignment updated successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Assignment update failed: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Delete an assignment
     * 
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $assignment = $this->assignmentRepository->find($id);

            if (!$assignment) {
                return $this->notFoundResponse('Assignment not found');
            }

            $this->assignmentRepository->delete($id);

            return $this->successResponse(null, 'Assignment deleted successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Assignment deletion failed: ' . $e->getMessage(), 500);
        }
    }
}
