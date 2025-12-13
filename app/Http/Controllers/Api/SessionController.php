<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Session\CreateSessionRequest;
use App\Repositories\Interfaces\SessionRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Session Controller
 * 
 * Handles session-related API endpoints
 * Uses Repository pattern for data access
 */
class SessionController extends Controller
{
    /**
     * @var SessionRepositoryInterface
     */
    protected $sessionRepository;

    /**
     * SessionController constructor
     * 
     * @param SessionRepositoryInterface $sessionRepository
     */
    public function __construct(SessionRepositoryInterface $sessionRepository)
    {
        $this->sessionRepository = $sessionRepository;
    }

    /**
     * Get sessions for a course
     * 
     * @param int $courseId
     * @return JsonResponse
     */
    public function courseSessions(int $courseId): JsonResponse
    {
        $sessions = $this->sessionRepository->getCourseSessions($courseId);

        return $this->successResponse($sessions, __('messages.session.retrieved_successfully'));
    }

    /**
     * Get upcoming sessions for a course
     * 
     * @param int $courseId
     * @return JsonResponse
     */
    public function upcomingSessions(int $courseId): JsonResponse
    {
        $sessions = $this->sessionRepository->getUpcomingSessions($courseId);

        return $this->successResponse($sessions, __('messages.session.retrieved_successfully'));
    }

    /**
     * Create a new session (Instructor/Admin only)
     * 
     * @param CreateSessionRequest $request
     * @return JsonResponse
     */
    public function store(CreateSessionRequest $request): JsonResponse
    {
        try {
            $session = $this->sessionRepository->create($request->validated());

            return $this->createdResponse($session, __('messages.session.created_successfully'));
        } catch (\Exception $e) {
            return $this->errorResponse(__('messages.session.creation_failed') . ': ' . $e->getMessage(), 500);
        }
    }
}
