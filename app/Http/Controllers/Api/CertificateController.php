<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\CertificateRepositoryInterface;
use App\Repositories\Interfaces\GradeRepositoryInterface;
use App\Repositories\Interfaces\AttendanceRepositoryInterface;
use App\Repositories\Interfaces\CourseRepositoryInterface;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * Certificate Controller
 * 
 * Handles certificate generation and download
 */
class CertificateController extends Controller
{
    /**
     * @var CertificateRepositoryInterface
     */
    protected $certificateRepository;

    /**
     * @var GradeRepositoryInterface
     */
    protected $gradeRepository;

    /**
     * @var AttendanceRepositoryInterface
     */
    protected $attendanceRepository;

    /**
     * @var CourseRepositoryInterface
     */
    protected $courseRepository;

    /**
     * CertificateController constructor
     */
    public function __construct(
        CertificateRepositoryInterface $certificateRepository,
        GradeRepositoryInterface $gradeRepository,
        AttendanceRepositoryInterface $attendanceRepository,
        CourseRepositoryInterface $courseRepository
    ) {
        $this->certificateRepository = $certificateRepository;
        $this->gradeRepository = $gradeRepository;
        $this->attendanceRepository = $attendanceRepository;
        $this->courseRepository = $courseRepository;
    }

    /**
     * Generate certificate for a course
     * 
     * @param int $courseId
     * @param Request $request
     * @return JsonResponse
     */
    public function generate(int $courseId, Request $request): JsonResponse
    {
        try {
            $userId = $request->user()->id;

            // Check if certificate already exists
            $existingCertificate = $this->certificateRepository->getUserCourseCertificate($userId, $courseId);
            if ($existingCertificate) {
                return $this->errorResponse(__('messages.certificate.already_generated'), 400);
            }

            // Check eligibility
            if (!$this->certificateRepository->isEligibleForCertificate($userId, $courseId)) {
                return $this->errorResponse(__('messages.certificate.not_eligible'), 403);
            }

            // Get data for certificate
            $finalGrade = $this->gradeRepository->calculateFinalGrade($userId, $courseId);
            $attendancePercentage = $this->attendanceRepository->calculateAttendancePercentage($userId, $courseId);

            // Generate certificate record
            $certificate = $this->certificateRepository->generateCertificate(
                $userId,
                $courseId,
                $finalGrade,
                $attendancePercentage
            );

            // Generate PDF
            $course = $this->courseRepository->find($courseId);
            $user = $request->user();

            $pdf = Pdf::loadView('certificates.template', [
                'userName' => $user->full_name,
                'courseName' => $course->title,
                'finalGrade' => $finalGrade,
                'attendancePercentage' => $attendancePercentage,
                'issuedDate' => $certificate->issued_at->format('F d, Y'),
                'certificateNumber' => $certificate->certificate_number,
            ]);

            // Save PDF
            $fileName = 'certificates/' . $certificate->certificate_number . '.pdf';
            Storage::disk('public')->put($fileName, $pdf->output());

            // Update certificate with file path
            $certificate->update(['file_url' => $fileName]);

            return $this->createdResponse($certificate, __('messages.certificate.generated_successfully'));
        } catch (\Exception $e) {
            return $this->errorResponse(__('messages.certificate.generation_failed') . ': ' . $e->getMessage(), 500);
        }
    }

    /**
     * Download certificate
     * 
     * @param int $courseId
     * @param Request $request
     * @return mixed
     */
    public function download(int $courseId, Request $request)
    {
        try {
            $userId = $request->user()->id;

            $certificate = $this->certificateRepository->getUserCourseCertificate($userId, $courseId);

            if (!$certificate) {
                return $this->notFoundResponse(__('messages.certificate.not_found'));
            }

            // Get raw file_url from database (not the accessor)
            $fileUrl = $certificate->getAttributes()['file_url'] ?? null;

            if (!$fileUrl || !Storage::disk('public')->exists($fileUrl)) {
                return $this->errorResponse(__('messages.certificate.file_not_found'), 404);
            }

            return response()->download(storage_path('app/public/' . $fileUrl), $certificate->certificate_number . '.pdf');
        } catch (\Exception $e) {
            return $this->errorResponse(__('messages.certificate.download_failed') . ': ' . $e->getMessage(), 500);
        }
    }

    /**
     * Get my certificate for a course
     * 
     * @param int $courseId
     * @param Request $request
     * @return JsonResponse
     */
    public function myCertificate(int $courseId, Request $request): JsonResponse
    {
        $certificate = $this->certificateRepository->getUserCourseCertificate($request->user()->id, $courseId);

        if (!$certificate) {
            return $this->notFoundResponse(__('messages.certificate.not_found'));
        }

        return $this->successResponse($certificate, __('messages.certificate.retrieved_successfully'));
    }

    /**
     * Check certificate eligibility
     * 
     * @param int $courseId
     * @param Request $request
     * @return JsonResponse
     */
    public function checkEligibility(int $courseId, Request $request): JsonResponse
    {
        $userId = $request->user()->id;
        $isEligible = $this->certificateRepository->isEligibleForCertificate($userId, $courseId);

        $finalGrade = $this->gradeRepository->calculateFinalGrade($userId, $courseId);
        $attendancePercentage = $this->attendanceRepository->calculateAttendancePercentage($userId, $courseId);

        return $this->successResponse([
            'eligible' => $isEligible,
            'final_grade' => $finalGrade,
            'attendance_percentage' => $attendancePercentage,
            'requirements' => [
                'min_attendance' => 75,
                'min_grade' => 60,
            ],
        ], __('messages.certificate.eligibility_checked'));
    }
}
