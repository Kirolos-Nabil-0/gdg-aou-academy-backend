<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Track\CreateTrackRequest;
use App\Http\Requests\Track\UpdateTrackRequest;
use App\Repositories\Interfaces\TrackRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Track Controller
 * 
 * Handles track-related API endpoints
 * Uses Repository pattern for data access
 */
class TrackController extends Controller
{

    /**
     * @var TrackRepositoryInterface
     */
    protected $trackRepository;

    /**
     * TrackController constructor
     * 
     * @param TrackRepositoryInterface $trackRepository
     */
    public function __construct(TrackRepositoryInterface $trackRepository)
    {
        $this->trackRepository = $trackRepository;
    }

    /**
     * Get all tracks
     * 
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $tracks = $this->trackRepository->getAllTracks(['id', 'name', 'name_ar', 'description']);

        return $this->successResponse($tracks, __('messages.track.retrieved_successfully'));
    }

    /**
     * Create new track (Admin only)
     * 
     * @param CreateTrackRequest $request
     * @return JsonResponse
     */
    public function store(CreateTrackRequest $request): JsonResponse
    {
        try {
            $track = $this->trackRepository->create($request->validated());

            return $this->createdResponse($track, 'Track created successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Track creation failed: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Get a specific track
     * 
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $track = $this->trackRepository->getTrackWithCoursesCount($id);

        if (!$track) {
            return $this->notFoundResponse(__('messages.track.not_found'));
        }

        return $this->successResponse($track);
    }

    /**
     * Update track (Admin only)
     * 
     * @param UpdateTrackRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateTrackRequest $request, int $id): JsonResponse
    {
        try {
            $track = $this->trackRepository->update($id, $request->validated());

            if (!$track) {
                return $this->notFoundResponse('Track not found');
            }

            return $this->successResponse($track, 'Track updated successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Track update failed: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Delete track (Admin only)
     * 
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $deleted = $this->trackRepository->delete($id);

            if (!$deleted) {
                return $this->notFoundResponse('Track not found');
            }

            return $this->successResponse(null, 'Track deleted successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Track deletion failed: ' . $e->getMessage(), 500);
        }
    }
}
