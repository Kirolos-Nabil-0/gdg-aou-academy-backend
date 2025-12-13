<?php

namespace App\Repositories\Interfaces;

use App\Models\AttendanceRecord;
use Illuminate\Database\Eloquent\Collection;

/**
 * Attendance Repository Interface
 * 
 * Defines attendance-specific operations
 */
interface AttendanceRepositoryInterface extends RepositoryInterface
{
    /**
     * Mark attendance for a session
     * 
     * @param int $sessionId
     * @param int $userId
     * @param string $status
     * @param int $markedBy
     * @return AttendanceRecord
     */
    public function markAttendance(int $sessionId, int $userId, string $status, int $markedBy): AttendanceRecord;

    /**
     * Get attendance for a session
     * 
     * @param int $sessionId
     * @return Collection
     */
    public function getSessionAttendance(int $sessionId): Collection;

    /**
     * Get user attendance for a course
     * 
     * @param int $userId
     * @param int $courseId
     * @return Collection
     */
    public function getUserCourseAttendance(int $userId, int $courseId): Collection;

    /**
     * Calculate attendance percentage for a user in a course
     * 
     * @param int $userId
     * @param int $courseId
     * @return float
     */
    public function calculateAttendancePercentage(int $userId, int $courseId): float;
}
