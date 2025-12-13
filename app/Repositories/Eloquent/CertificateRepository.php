<?php

namespace App\Repositories\Eloquent;

use App\Models\Certificate;
use App\Repositories\Interfaces\CertificateRepositoryInterface;
use App\Repositories\Interfaces\GradeRepositoryInterface;
use App\Repositories\Interfaces\AttendanceRepositoryInterface;

/**
 * Certificate Repository
 * 
 * Handles all certificate-related database operations
 */
class CertificateRepository extends BaseRepository implements CertificateRepositoryInterface
{
    /**
     * @var GradeRepositoryInterface
     */
    protected $gradeRepository;

    /**
     * @var AttendanceRepositoryInterface
     */
    protected $attendanceRepository;

    /**
     * CertificateRepository constructor
     * 
     * @param Certificate $model
     * @param GradeRepositoryInterface $gradeRepository
     * @param AttendanceRepositoryInterface $attendanceRepository
     */
    public function __construct(
        Certificate $model,
        GradeRepositoryInterface $gradeRepository,
        AttendanceRepositoryInterface $attendanceRepository
    ) {
        parent::__construct($model);
        $this->gradeRepository = $gradeRepository;
        $this->attendanceRepository = $attendanceRepository;
    }

    /**
     * Generate certificate for a user in a course
     * 
     * @param int $userId
     * @param int $courseId
     * @param float $finalGrade
     * @param float $attendancePercentage
     * @return Certificate
     */
    public function generateCertificate(int $userId, int $courseId, float $finalGrade, float $attendancePercentage): Certificate
    {
        return $this->create([
            'user_id' => $userId,
            'course_id' => $courseId,
            'file_url' => '', // Will be updated after PDF generation
            'status' => 'issued',
            'criteria_snapshot' => [
                'final_grade' => $finalGrade,
                'attendance_percentage' => $attendancePercentage,
            ],
            'issued_at' => now(),
        ]);
    }

    /**
     * Get user's certificate for a course
     * 
     * @param int $userId
     * @param int $courseId
     * @return Certificate|null
     */
    public function getUserCourseCertificate(int $userId, int $courseId): ?Certificate
    {
        return $this->model
            ->where('user_id', $userId)
            ->where('course_id', $courseId)
            ->with(['user', 'course'])
            ->first();
    }

    /**
     * Check if user is eligible for certificate
     * 
     * Criteria:
     * - Attendance >= 75%
     * - Final Grade >= 60%
     * 
     * @param int $userId
     * @param int $courseId
     * @return bool
     */
    public function isEligibleForCertificate(int $userId, int $courseId): bool
    {
        $attendancePercentage = $this->attendanceRepository->calculateAttendancePercentage($userId, $courseId);
        $finalGrade = $this->gradeRepository->calculateFinalGrade($userId, $courseId);

        return $attendancePercentage >= 75 && $finalGrade >= 60;
    }
}
