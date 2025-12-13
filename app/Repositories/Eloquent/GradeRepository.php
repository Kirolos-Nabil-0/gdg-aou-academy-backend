<?php

namespace App\Repositories\Eloquent;

use App\Models\Grade;
use App\Models\Assignment;
use App\Repositories\Interfaces\GradeRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

/**
 * Grade Repository
 * 
 * Handles all grade-related database operations
 */
class GradeRepository extends BaseRepository implements GradeRepositoryInterface
{
    /**
     * GradeRepository constructor
     * 
     * @param Grade $model
     */
    public function __construct(Grade $model)
    {
        parent::__construct($model);
    }

    /**
     * Submit or update a grade
     * 
     * @param int $assignmentId
     * @param int $userId
     * @param float $score
     * @param int $gradedBy
     * @param string|null $feedback
     * @return Grade
     */
    public function submitGrade(int $assignmentId, int $userId, float $score, int $gradedBy, ?string $feedback = null): Grade
    {
        // Check if grade already exists
        $grade = $this->model
            ->where('assignment_id', $assignmentId)
            ->where('user_id', $userId)
            ->first();

        if ($grade) {
            // Update existing grade
            $grade->update([
                'grade_value' => $score,
                'status' => 'final',
                'graded_by' => $gradedBy,
                'graded_at' => now(),
            ]);
            return $grade;
        }

        // Create new grade
        return $this->create([
            'assignment_id' => $assignmentId,
            'user_id' => $userId,
            'grade_value' => $score,
            'status' => 'final',
            'graded_by' => $gradedBy,
            'graded_at' => now(),
        ]);
    }

    /**
     * Get grades for an assignment
     * 
     * @param int $assignmentId
     * @return Collection
     */
    public function getAssignmentGrades(int $assignmentId): Collection
    {
        return $this->model
            ->where('assignment_id', $assignmentId)
            ->with(['user', 'gradedBy'])
            ->get();
    }

    /**
     * Get user's grades for a course
     * 
     * @param int $userId
     * @param int $courseId
     * @return Collection
     */
    public function getUserCourseGrades(int $userId, int $courseId): Collection
    {
        return $this->model
            ->where('user_id', $userId)
            ->whereHas('assignment', function ($query) use ($courseId) {
                $query->where('course_id', $courseId);
            })
            ->with(['assignment'])
            ->get();
    }

    /**
     * Calculate final grade for a user in a course (weighted average)
     * 
     * @param int $userId
     * @param int $courseId
     * @return float
     */
    public function calculateFinalGrade(int $userId, int $courseId): float
    {
        // Get all assignments for the course
        $assignments = Assignment::where('course_id', $courseId)->get();

        if ($assignments->isEmpty()) {
            return 0.0;
        }

        $totalWeight = $assignments->sum('weight');
        $weightedSum = 0.0;

        foreach ($assignments as $assignment) {
            // Get user's grade for this assignment
            $grade = $this->model
                ->where('assignment_id', $assignment->id)
                ->where('user_id', $userId)
                ->first();

            if ($grade) {
                // Calculate weighted score
                $weightedSum += ($grade->grade_value * $assignment->weight);
            }
        }

        // Calculate final weighted average
        return $totalWeight > 0 ? round($weightedSum / $totalWeight, 2) : 0.0;
    }
}
