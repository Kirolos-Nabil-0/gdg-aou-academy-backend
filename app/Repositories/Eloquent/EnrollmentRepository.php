<?php

namespace App\Repositories\Eloquent;

use App\Models\Enrollment;
use App\Repositories\Interfaces\EnrollmentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

/**
 * Enrollment Repository
 * 
 * Handles all enrollment-related database operations
 */
class EnrollmentRepository extends BaseRepository implements EnrollmentRepositoryInterface
{
    /**
     * EnrollmentRepository constructor
     * 
     * @param Enrollment $model
     */
    public function __construct(Enrollment $model)
    {
        parent::__construct($model);
    }

    /**
     * Enroll a user in a course
     * 
     * @param int $userId
     * @param int $courseId
     * @param int|null $enrolledBy
     * @return Enrollment
     */
    public function enrollUser(int $userId, int $courseId, ?int $enrolledBy = null): Enrollment
    {
        return $this->create([
            'user_id' => $userId,
            'course_id' => $courseId,
            'status' => 'enrolled',
            'enrolled_at' => now(),
        ]);
    }

    /**
     * Check if user is enrolled in course
     * 
     * @param int $userId
     * @param int $courseId
     * @return bool
     */
    public function isEnrolled(int $userId, int $courseId): bool
    {
        return $this->model
            ->where('user_id', $userId)
            ->where('course_id', $courseId)
            ->exists();
    }

    /**
     * Get user enrollments
     * 
     * @param int $userId
     * @return Collection
     */
    public function getUserEnrollments(int $userId): Collection
    {
        return $this->model
            ->where('user_id', $userId)
            ->with(['course', 'course.track'])
            ->get();
    }

    /**
     * Get course enrollments
     * 
     * @param int $courseId
     * @return Collection
     */
    public function getCourseEnrollments(int $courseId): Collection
    {
        return $this->model
            ->where('course_id', $courseId)
            ->with(['user'])
            ->get();
    }

    /**
     * Update enrollment status
     * 
     * @param int $enrollmentId
     * @param string $status
     * @return Enrollment|null
     */
    public function updateStatus(int $enrollmentId, string $status): ?Enrollment
    {
        $enrollment = $this->find($enrollmentId);

        if ($enrollment) {
            $enrollment->update(['status' => $status]);

            if ($status === 'completed') {
                $enrollment->update(['completion_date' => now()]);
            }
        }

        return $enrollment;
    }

    /**
     * Unenroll user from course
     * 
     * @param int $userId
     * @param int $courseId
     * @return bool
     */
    public function unenrollUser(int $userId, int $courseId): bool
    {
        return $this->model
            ->where('user_id', $userId)
            ->where('course_id', $courseId)
            ->delete();
    }
}
