<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Course\StoreCourseRequest;
use App\Http\Requests\Course\UpdateCourseRequest;
use App\Repositories\Interfaces\CourseRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Course Controller
 * 
 * Handles course-related API endpoints
 * Uses Repository pattern for data access
 */
class CourseController extends Controller
{
    /**
     * @var CourseRepositoryInterface
     */
    protected $courseRepository;

    /**
     * CourseController constructor
     * 
     * @param CourseRepositoryInterface $courseRepository
     */
    public function __construct(CourseRepositoryInterface $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }

    /**
     * Get all courses with pagination and filters
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $filters = $request->only(['status', 'track_id', 'visibility', 'is_enrollable', 'search']);
        $perPage = $request->input('per_page', 15);

        $courses = $this->courseRepository->getAllCourses($filters, $perPage);

        return $this->successResponse($courses, __('messages.course.retrieved_successfully'));
    }

    /**
     * Get a specific course with relationships
     * 
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $course = $this->courseRepository->getCourseWithRelations($id);

        if (!$course) {
            return $this->notFoundResponse(__('messages.course.not_found'));
        }

        return $this->successResponse($course);
    }

    /**
     * Create a new course
     * 
     * @param StoreCourseRequest $request
     * @return JsonResponse
     */
    public function store(StoreCourseRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $data['created_by'] = $request->user()->id;

            $course = $this->courseRepository->create($data);

            return $this->createdResponse($course, __('messages.course.created_successfully'));
        } catch (\Exception $e) {
            return $this->errorResponse(__('messages.course.creation_failed') . ': ' . $e->getMessage(), 500);
        }
    }

    /**
     * Update a course
     * 
     * @param UpdateCourseRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateCourseRequest $request, int $id): JsonResponse
    {
        try {
            $course = $this->courseRepository->find($id);

            if (!$course) {
                return $this->notFoundResponse(__('messages.course.not_found'));
            }

            $updatedCourse = $this->courseRepository->update($id, $request->validated());

            return $this->successResponse($updatedCourse, __('messages.course.updated_successfully'));
        } catch (\Exception $e) {
            return $this->errorResponse(__('messages.course.update_failed') . ': ' . $e->getMessage(), 500);
        }
    }

    /**
     * Delete a course
     * 
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $course = $this->courseRepository->find($id);

            if (!$course) {
                return $this->notFoundResponse(__('messages.course.not_found'));
            }

            $this->courseRepository->delete($id);

            return $this->successResponse(null, __('messages.course.deleted_successfully'));
        } catch (\Exception $e) {
            return $this->errorResponse(__('messages.course.deletion_failed') . ': ' . $e->getMessage(), 500);
        }
    }

    /**
     * Get published courses (public endpoint)
     * 
     * @return JsonResponse
     */
    public function published(): JsonResponse
    {
        $courses = $this->courseRepository->getPublishedCourses();

        return $this->successResponse($courses, __('messages.course.retrieved_successfully'));
    }
}
