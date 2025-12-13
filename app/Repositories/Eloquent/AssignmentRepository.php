<?php

namespace App\Repositories\Eloquent;

use App\Models\Assignment;
use App\Repositories\Interfaces\AssignmentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

/**
 * Assignment Repository
 * 
 * Handles all assignment-related database operations
 */
class AssignmentRepository extends BaseRepository implements AssignmentRepositoryInterface
{
    /**
     * AssignmentRepository constructor
     * 
     * @param Assignment $model
     */
    public function __construct(Assignment $model)
    {
        parent::__construct($model);
    }

    /**
     * Get assignments for a course
     * 
     * @param int $courseId
     * @return Collection
     */
    public function getCourseAssignments(int $courseId): Collection
    {
        return $this->model
            ->where('course_id', $courseId)
            ->orderBy('due_at', 'asc')
            ->get();
    }

    /**
     * Get assignment with grades
     * 
     * @param int $id
     * @return Assignment|null
     */
    public function getAssignmentWithGrades(int $id): ?Assignment
    {
        return $this->model
            ->with(['grades.user', 'course'])
            ->find($id);
    }
}
