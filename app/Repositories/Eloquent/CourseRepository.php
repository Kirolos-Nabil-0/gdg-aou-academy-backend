<?php

namespace App\Repositories\Eloquent;

use App\Models\Course;
use App\Repositories\Interfaces\CourseRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Course Repository
 * 
 * Handles all course-related database operations
 */
class CourseRepository extends BaseRepository implements CourseRepositoryInterface
{
    /**
     * CourseRepository constructor
     * 
     * @param Course $model
     */
    public function __construct(Course $model)
    {
        parent::__construct($model);
    }

    /**
     * Get all courses with pagination and filters
     * 
     * @param array $filters
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getAllCourses(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = $this->model->with(['track', 'instructor']);

        // Filter by status
        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        // Filter by track
        if (isset($filters['track_id'])) {
            $query->where('track_id', $filters['track_id']);
        }

        // Filter by visibility
        if (isset($filters['visibility'])) {
            $query->where('visibility', $filters['visibility']);
        }

        // Filter by enrollability
        if (isset($filters['is_enrollable'])) {
            $query->where('is_enrollable', $filters['is_enrollable']);
        }

        // Search by title
        if (isset($filters['search'])) {
            $query->where('title', 'like', '%' . $filters['search'] . '%');
        }

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    /**
     * Get course with relationships
     * 
     * @param int $id
     * @return Course|null
     */
    public function getCourseWithRelations(int $id): ?Course
    {
        return $this->model
            ->with(['track', 'instructor', 'creator', 'enrollments', 'sessions'])
            ->find($id);
    }

    /**
     * Get courses by track
     * 
     * @param int $trackId
     * @return Collection
     */
    public function getCoursesByTrack(int $trackId): Collection
    {
        return $this->model
            ->where('track_id', $trackId)
            ->where('status', 'published')
            ->where('visibility', 'public')
            ->get();
    }

    /**
     * Get published courses
     * 
     * @return Collection
     */
    public function getPublishedCourses(): Collection
    {
        return $this->model
            ->where('status', 'published')
            ->where('visibility', 'public')
            ->with(['track', 'instructor'])
            ->get();
    }
}
