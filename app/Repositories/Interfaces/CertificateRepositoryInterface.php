<?php

namespace App\Repositories\Interfaces;

use App\Models\Certificate;

/**
 * Certificate Repository Interface
 * 
 * Defines certificate-specific operations
 */
interface CertificateRepositoryInterface extends RepositoryInterface
{
    /**
     * Generate certificate for a user in a course
     * 
     * @param int $userId
     * @param int $courseId
     * @param float $finalGrade
     * @param float $attendancePercentage
     * @return Certificate
     */
    public function generateCertificate(int $userId, int $courseId, float $finalGrade, float $attendancePercentage): Certificate;

    /**
     * Get user's certificate for a course
     * 
     * @param int $userId
     * @param int $courseId
     * @return Certificate|null
     */
    public function getUserCourseCertificate(int $userId, int $courseId): ?Certificate;

    /**
     * Check if user is eligible for certificate
     * 
     * @param int $userId
     * @param int $courseId
     * @return bool
     */
    public function isEligibleForCertificate(int $userId, int $courseId): bool;
}
