<?php

namespace App\Repositories\Interfaces;

use App\Models\Course;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Course Repository Interface
 * 
 * Defines course-specific operations
 */
interface CourseRepositoryInterface extends RepositoryInterface
{
    /**
     * Get all courses with pagination and filters
     * 
     * @param array $filters
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getAllCourses(array $filters = [], int $perPage = 15): LengthAwarePaginator;

    /**
     * Get course with relationships
     * 
     * @param int $id
     * @return Course|null
     */
    public function getCourseWithRelations(int $id): ?Course;

    /**
     * Get courses by track
     * 
     * @param int $trackId
     * @return Collection
     */
    public function getCoursesByTrack(int $trackId): Collection;

    /**
     * Get published courses
     * 
     * @return Collection
     */
    public function getPublishedCourses(): Collection;
}
