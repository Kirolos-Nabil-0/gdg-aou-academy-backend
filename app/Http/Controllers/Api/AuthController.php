<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

/**
 * Authentication Controller
 * 
 * Handles user authentication using Repository pattern
 */
class AuthController extends Controller
{
    /**
     * @var UserRepositoryInterface
     */
    protected $userRepository;

    /**
     * AuthController constructor
     * 
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Register a new user
     * 
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            // Create user via repository
            $user = $this->userRepository->createUser($request->validated());

            // Assign default Learner role
            $this->userRepository->assignRole($user, 'Learner');

            // Create API token
            $token = $user->createToken('auth_token')->plainTextToken;

            return $this->createdResponse([
                'user' => [
                    'id' => $user->id,
                    'full_name' => $user->full_name,
                    'email' => $user->email,
                    'college_id' => $user->college_id,
                    'is_cs' => $user->is_cs,
                    'locale' => $user->locale,
                    'roles' => $user->getRoleNames(),
                ],
                'token' => $token,
            ], __('messages.auth.registration_successful'));

        } catch (\Exception $e) {
            return $this->errorResponse(__('messages.auth.registration_failed') . ': ' . $e->getMessage(), 500);
        }
    }

    /**
     * Login user
     * 
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        // Attempt to authenticate
        if (!Auth::attempt($request->only('email', 'password'))) {
            return $this->unauthorizedResponse(__('messages.auth.invalid_credentials'));
        }

        $user = Auth::user();

        // Create API token
        $token = $user->createToken('auth_token')->plainTextToken;

        return $this->successResponse([
            'user' => [
                'id' => $user->id,
                'full_name' => $user->full_name,
                'email' => $user->email,
                'college_id' => $user->college_id,
                'is_cs' => $user->is_cs,
                'locale' => $user->locale,
                'roles' => $user->getRoleNames(),
                'permissions' => $user->getAllPermissions()->pluck('name'),
            ],
            'token' => $token,
        ], __('messages.auth.login_successful'));
    }

    /**
     * Logout user (revoke current token)
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        // Revoke current token
        $request->user()->currentAccessToken()->delete();

        return $this->successResponse(null, __('messages.auth.logout_successful'));
    }

    /**
     * Logout from all devices (revoke all tokens)
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function logoutAll(Request $request): JsonResponse
    {
        // Revoke all tokens
        $request->user()->tokens()->delete();

        return $this->successResponse(null, __('messages.auth.logout_all_successful'));
    }

    /**
     * Request password reset (sends email with reset link)
     * 
     * @param ForgotPasswordRequest $request
     * @return JsonResponse
     */
    public function forgotPassword(ForgotPasswordRequest $request): JsonResponse
    {
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return $this->successResponse(null, __('messages.auth.password_reset_link_sent'));
        }

        return $this->errorResponse(__('messages.auth.password_reset_failed'), 500);
    }

    /**
     * Reset password
     * 
     * @param ResetPasswordRequest $request
     * @return JsonResponse
     */
    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return $this->successResponse(null, __('messages.auth.password_reset_successful'));
        }

        return $this->errorResponse(__('messages.auth.password_reset_error'), 400);
    }

    /**
     * Get authenticated user profile
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function me(Request $request): JsonResponse
    {
        $user = $request->user();

        return $this->successResponse([
            'id' => $user->id,
            'full_name' => $user->full_name,
            'email' => $user->email,
            'college_id' => $user->college_id,
            'is_cs' => $user->is_cs,
            'locale' => $user->locale,
            'email_verified_at' => $user->email_verified_at,
            'roles' => $user->getRoleNames(),
            'permissions' => $user->getAllPermissions()->pluck('name'),
            'created_at' => $user->created_at,
        ]);
    }
}
