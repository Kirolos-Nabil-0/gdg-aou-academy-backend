<?php

namespace App\Repositories\Interfaces;

use App\Models\Session;
use Illuminate\Database\Eloquent\Collection;

/**
 * Session Repository Interface
 * 
 * Defines session-specific operations
 */
interface SessionRepositoryInterface extends RepositoryInterface
{
    /**
     * Get sessions for a course
     * 
     * @param int $courseId
     * @return Collection
     */
    public function getCourseSessions(int $courseId): Collection;

    /**
     * Get upcoming sessions
     * 
     * @param int $courseId
     * @return Collection
     */
    public function getUpcomingSessions(int $courseId): Collection;
}
