<?php

namespace App\Repositories\Eloquent;

use App\Models\Session;
use App\Repositories\Interfaces\SessionRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

/**
 * Session Repository
 * 
 * Handles all session-related database operations
 */
class SessionRepository extends BaseRepository implements SessionRepositoryInterface
{
    /**
     * SessionRepository constructor
     * 
     * @param Session $model
     */
    public function __construct(Session $model)
    {
        parent::__construct($model);
    }

    /**
     * Get sessions for a course
     * 
     * @param int $courseId
     * @return Collection
     */
    public function getCourseSessions(int $courseId): Collection
    {
        return $this->model
            ->where('course_id', $courseId)
            ->orderBy('start_at', 'asc')
            ->get();
    }

    /**
     * Get upcoming sessions
     * 
     * @param int $courseId
     * @return Collection
     */
    public function getUpcomingSessions(int $courseId): Collection
    {
        return $this->model
            ->where('course_id', $courseId)
            ->where('start_at', '>=', now())
            ->orderBy('start_at', 'asc')
            ->get();
    }
}
