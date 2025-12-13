<?php

namespace App\Http\Traits;

use Illuminate\Http\JsonResponse;

/**
 * API Response Trait
 * 
 * Provides unified response format across all API endpoints
 * Ensures consistency in success/error responses
 */
trait ApiResponse
{
    /**
     * Return a success JSON response
     *
     * @param mixed $data Response data
     * @param string $message Success message
     * @param int $code HTTP status code
     * @return JsonResponse
     */
    protected function successResponse($data = null, string $message = 'Operation completed successfully', int $code = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    /**
     * Return an error JSON response
     *
     * @param string $message Error message
     * @param int $code HTTP status code
     * @param mixed $errors Additional error details
     * @return JsonResponse
     */
    protected function errorResponse(string $message = 'An error occurred', int $code = 400, $errors = null): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $message,
        ];

        if ($errors !== null) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $code);
    }

    /**
     * Return a validation error response
     *
     * @param array $errors Validation errors
     * @param string $message Error message
     * @return JsonResponse
     */
    protected function validationErrorResponse(array $errors, string $message = 'Validation failed'): JsonResponse
    {
        return $this->errorResponse($message, 422, $errors);
    }

    /**
     * Return a not found response
     *
     * @param string $message Not found message
     * @return JsonResponse
     */
    protected function notFoundResponse(string $message = 'Resource not found'): JsonResponse
    {
        return $this->errorResponse($message, 404);
    }

    /**
     * Return an unauthorized response
     *
     * @param string $message Unauthorized message
     * @return JsonResponse
     */
    protected function unauthorizedResponse(string $message = 'Unauthorized access'): JsonResponse
    {
        return $this->errorResponse($message, 401);
    }

    /**
     * Return a forbidden response
     *
     * @param string $message Forbidden message
     * @return JsonResponse
     */
    protected function forbiddenResponse(string $message = 'Access forbidden'): JsonResponse
    {
        return $this->errorResponse($message, 403);
    }

    /**
     * Return a created response (for POST requests)
     *
     * @param mixed $data Created resource data
     * @param string $message Success message
     * @return JsonResponse
     */
    protected function createdResponse($data = null, string $message = 'Resource created successfully'): JsonResponse
    {
        return $this->successResponse($data, $message, 201);
    }

    /**
     * Return a no content response (for DELETE requests)
     *
     * @return JsonResponse
     */
    protected function noContentResponse(): JsonResponse
    {
        return response()->json(null, 204);
    }
}
