<?php

namespace App\Repositories\Eloquent;

use App\Models\AttendanceRecord;
use App\Models\Session;
use App\Repositories\Interfaces\AttendanceRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

/**
 * Attendance Repository
 * 
 * Handles all attendance-related database operations
 */
class AttendanceRepository extends BaseRepository implements AttendanceRepositoryInterface
{
    /**
     * AttendanceRepository constructor
     * 
     * @param AttendanceRecord $model
     */
    public function __construct(AttendanceRecord $model)
    {
        parent::__construct($model);
    }

    /**
     * Mark attendance for a session
     * 
     * @param int $sessionId
     * @param int $userId
     * @param string $status
     * @param int $markedBy
     * @return AttendanceRecord
     */
    public function markAttendance(int $sessionId, int $userId, string $status, int $markedBy): AttendanceRecord
    {
        // Check if attendance already exists
        $attendance = $this->model
            ->where('session_id', $sessionId)
            ->where('user_id', $userId)
            ->first();

        if ($attendance) {
            // Update existing attendance
            $attendance->update([
                'status' => $status,
                'marked_at' => now(),
                'marked_by' => $markedBy,
            ]);
            return $attendance;
        }

        // Create new attendance record
        return $this->create([
            'session_id' => $sessionId,
            'user_id' => $userId,
            'status' => $status,
            'marked_at' => now(),
            'marked_by' => $markedBy,
        ]);
    }

    /**
     * Get attendance for a session
     * 
     * @param int $sessionId
     * @return Collection
     */
    public function getSessionAttendance(int $sessionId): Collection
    {
        return $this->model
            ->where('session_id', $sessionId)
            ->with(['user'])
            ->get();
    }

    /**
     * Get user attendance for a course
     * 
     * @param int $userId
     * @param int $courseId
     * @return Collection
     */
    public function getUserCourseAttendance(int $userId, int $courseId): Collection
    {
        return $this->model
            ->where('user_id', $userId)
            ->whereHas('session', function ($query) use ($courseId) {
                $query->where('course_id', $courseId);
            })
            ->with(['session'])
            ->get();
    }

    /**
     * Calculate attendance percentage for a user in a course
     * 
     * @param int $userId
     * @param int $courseId
     * @return float
     */
    public function calculateAttendancePercentage(int $userId, int $courseId): float
    {
        // Get total sessions for the course
        $totalSessions = Session::where('course_id', $courseId)->count();

        if ($totalSessions === 0) {
            return 0.0;
        }

        // Get attended sessions (status = 'present')
        $attendedSessions = $this->model
            ->where('user_id', $userId)
            ->where('status', 'present')
            ->whereHas('session', function ($query) use ($courseId) {
                $query->where('course_id', $courseId);
            })
            ->count();

        return round(($attendedSessions / $totalSessions) * 100, 2);
    }
}
