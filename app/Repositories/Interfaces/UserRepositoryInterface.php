<?php

namespace App\Repositories\Interfaces;

use App\Models\User;

/**
 * User Repository Interface
 * 
 * Defines user-specific operations
 */
interface UserRepositoryInterface extends RepositoryInterface
{
    /**
     * Create a new user with encrypted sensitive data
     * 
     * @param array $data
     * @return User
     */
    public function createUser(array $data): User;

    /**
     * Find user by email
     * 
     * @param string $email
     * @return User|null
     */
    public function findByEmail(string $email): ?User;

    /**
     * Assign role to user
     * 
     * @param User $user
     * @param string $role
     * @return void
     */
    public function assignRole(User $user, string $role): void;

    /**
     * Get user with roles and permissions
     * 
     * @param int $id
     * @return User|null
     */
    public function getUserWithRolesAndPermissions(int $id): ?User;

    /**
     * Get all users with roles and optional filters
     * 
     * @param array $filters
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAllWithRoles(array $filters = []);

    /**
     * Create user with role assignment
     * 
     * @param array $data
     * @param string $role
     * @return User
     */
    public function createWithRole(array $data, string $role): User;

    /**
     * Update user details
     * 
     * @param int $id
     * @param array $data
     * @return User|null
     */
    public function updateUser(int $id, array $data): ?User;

    /**
     * Delete user (soft delete)
     * 
     * @param int $id
     * @return bool
     */
    public function deleteUser(int $id): bool;
}
