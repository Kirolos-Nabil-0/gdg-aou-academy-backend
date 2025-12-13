<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\College\CreateCollegeRequest;
use App\Http\Requests\College\UpdateCollegeRequest;
use App\Repositories\Interfaces\CollegeRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * College Controller
 * 
 * Handles college-related API endpoints
 * Uses Repository pattern for data access
 */
class CollegeController extends Controller
{

    /**
     * @var CollegeRepositoryInterface
     */
    protected $collegeRepository;

    /**
     * CollegeController constructor
     * 
     * @param CollegeRepositoryInterface $collegeRepository
     */
    public function __construct(CollegeRepositoryInterface $collegeRepository)
    {
        $this->collegeRepository = $collegeRepository;
    }

    /**
     * Get all colleges
     * 
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $colleges = $this->collegeRepository->getAllColleges(['id', 'name', 'name_ar']);

        return $this->successResponse($colleges, __('messages.college.retrieved_successfully'));
    }

    /**
     * Create new college (Admin only)
     * 
     * @param CreateCollegeRequest $request
     * @return JsonResponse
     */
    public function store(CreateCollegeRequest $request): JsonResponse
    {
        try {
            $college = $this->collegeRepository->create($request->validated());

            return $this->createdResponse($college, 'College created successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('College creation failed: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Get a specific college
     * 
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $college = $this->collegeRepository->find($id);

        if (!$college) {
            return $this->notFoundResponse(__('messages.college.not_found'));
        }

        return $this->successResponse($college);
    }

    /**
     * Update college (Admin only)
     * 
     * @param UpdateCollegeRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateCollegeRequest $request, int $id): JsonResponse
    {
        try {
            $college = $this->collegeRepository->update($id, $request->validated());

            if (!$college) {
                return $this->notFoundResponse('College not found');
            }

            return $this->successResponse($college, 'College updated successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('College update failed: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Delete college (Admin only)
     * 
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $deleted = $this->collegeRepository->delete($id);

            if (!$deleted) {
                return $this->notFoundResponse('College not found');
            }

            return $this->successResponse(null, 'College deleted successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('College deletion failed: ' . $e->getMessage(), 500);
        }
    }
}
