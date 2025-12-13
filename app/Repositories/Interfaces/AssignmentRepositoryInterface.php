<?php

namespace App\Repositories\Interfaces;

use App\Models\Assignment;
use Illuminate\Database\Eloquent\Collection;

/**
 * Assignment Repository Interface
 * 
 * Defines assignment-specific operations
 */
interface AssignmentRepositoryInterface extends RepositoryInterface
{
    /**
     * Get assignments for a course
     * 
     * @param int $courseId
     * @return Collection
     */
    public function getCourseAssignments(int $courseId): Collection;

    /**
     * Get assignment with grades
     * 
     * @param int $id
     * @return Assignment|null
     */
    public function getAssignmentWithGrades(int $id): ?Assignment;
}
