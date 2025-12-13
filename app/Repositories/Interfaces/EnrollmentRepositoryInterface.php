<?php

namespace App\Repositories\Interfaces;

use App\Models\Enrollment;
use Illuminate\Database\Eloquent\Collection;

/**
 * Enrollment Repository Interface
 * 
 * Defines enrollment-specific operations
 */
interface EnrollmentRepositoryInterface extends RepositoryInterface
{
    /**
     * Enroll a user in a course
     * 
     * @param int $userId
     * @param int $courseId
     * @param int|null $enrolledBy
     * @return Enrollment
     */
    public function enrollUser(int $userId, int $courseId, ?int $enrolledBy = null): Enrollment;

    /**
     * Check if user is enrolled in course
     * 
     * @param int $userId
     * @param int $courseId
     * @return bool
     */
    public function isEnrolled(int $userId, int $courseId): bool;

    /**
     * Get user enrollments
     * 
     * @param int $userId
     * @return Collection
     */
    public function getUserEnrollments(int $userId): Collection;

    /**
     * Get course enrollments
     * 
     * @param int $courseId
     * @return Collection
     */
    public function getCourseEnrollments(int $courseId): Collection;

    /**
     * Update enrollment status
     * 
     * @param int $enrollmentId
     * @param string $status
     * @return Enrollment|null
     */
    public function updateStatus(int $enrollmentId, string $status): ?Enrollment;

    /**
     * Unenroll user from course
     * 
     * @param int $userId
     * @param int $courseId
     * @return bool
     */
    public function unenrollUser(int $userId, int $courseId): bool;
}
