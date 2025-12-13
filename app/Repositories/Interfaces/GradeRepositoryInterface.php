<?php

namespace App\Repositories\Interfaces;

use App\Models\Grade;
use Illuminate\Database\Eloquent\Collection;

/**
 * Grade Repository Interface
 * 
 * Defines grade-specific operations
 */
interface GradeRepositoryInterface extends RepositoryInterface
{
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
    public function submitGrade(int $assignmentId, int $userId, float $score, int $gradedBy, ?string $feedback = null): Grade;

    /**
     * Get grades for an assignment
     * 
     * @param int $assignmentId
     * @return Collection
     */
    public function getAssignmentGrades(int $assignmentId): Collection;

    /**
     * Get user's grades for a course
     * 
     * @param int $userId
     * @param int $courseId
     * @return Collection
     */
    public function getUserCourseGrades(int $userId, int $courseId): Collection;

    /**
     * Calculate final grade for a user in a course (weighted average)
     * 
     * @param int $userId
     * @param int $courseId
     * @return float
     */
    public function calculateFinalGrade(int $userId, int $courseId): float;
}
