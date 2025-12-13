<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Requests\User\AssignRoleRequest;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * User Controller
 * 
 * Handles user management operations (Admin only)
 */
class UserController extends Controller
{
    /**
     * @var UserRepositoryInterface
     */
    protected $userRepository;

    /**
     * UserController constructor
     * 
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * List all users with optional filters (Admin only)
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $filters = [
            'role' => $request->query('role'),
            'college_id' => $request->query('college_id'),
            'search' => $request->query('search'),
            'is_cs' => $request->query('is_cs'),
            'per_page' => $request->query('per_page', 15),
        ];

        $users = $this->userRepository->getAllWithRoles($filters);

        return $this->successResponse($users, 'Users retrieved successfully');
    }

    /**
     * Create new user (Admin only)
     * 
     * @param CreateUserRequest $request
     * @return JsonResponse
     */
    public function store(CreateUserRequest $request): JsonResponse
    {
        try {
            $user = $this->userRepository->createWithRole(
                $request->validated(),
                $request->role
            );

            return $this->createdResponse($user, 'User created successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('User creation failed: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Get user details (Admin only)
     * 
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $user = $this->userRepository->getUserWithRolesAndPermissions($id);

        if (!$user) {
            return $this->notFoundResponse('User not found');
        }

        return $this->successResponse($user, 'User retrieved successfully');
    }

    /**
     * Update user (Admin only)
     * 
     * @param UpdateUserRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateUserRequest $request, int $id): JsonResponse
    {
        try {
            $user = $this->userRepository->updateUser($id, $request->validated());

            if (!$user) {
                return $this->notFoundResponse('User not found');
            }

            return $this->successResponse($user, 'User updated successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('User update failed: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Delete user (Admin only)
     * Prevents admin from deleting themselves
     * 
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(Request $request, int $id): JsonResponse
    {
        try {
            // Prevent self-deletion
            if ($request->user()->id === $id) {
                return $this->errorResponse('You cannot delete yourself', 403);
            }

            $deleted = $this->userRepository->deleteUser($id);

            if (!$deleted) {
                return $this->notFoundResponse('User not found');
            }

            return $this->successResponse(null, 'User deleted successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('User deletion failed: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Assign role to user (Admin only)
     * 
     * @param AssignRoleRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function assignRole(AssignRoleRequest $request, int $id): JsonResponse
    {
        try {
            $user = $this->userRepository->find($id);

            if (!$user) {
                return $this->notFoundResponse('User not found');
            }

            // Remove all existing roles and assign new one
            $user->syncRoles([$request->role]);

            return $this->successResponse(
                $user->load('roles'),
                'Role assigned successfully'
            );
        } catch (\Exception $e) {
            return $this->errorResponse('Role assignment failed: ' . $e->getMessage(), 500);
        }
    }
}
