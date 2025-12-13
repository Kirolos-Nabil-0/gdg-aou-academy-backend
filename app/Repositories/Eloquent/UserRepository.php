<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

/**
 * User Repository
 * 
 * Handles all user-related database operations
 */
class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    /**
     * UserRepository constructor
     * 
     * @param User $model
     */
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    /**
     * Create a new user with encrypted sensitive data
     * 
     * @param array $data
     * @return User
     */
    public function createUser(array $data): User
    {
        // Prepare user data with encryption
        $userData = [
            'full_name' => $data['full_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'college_id' => $data['college_id'],
            'is_cs' => $data['is_cs'],
            'national_id_encrypted' => Crypt::encryptString($data['national_id']),
            'phone_encrypted' => Crypt::encryptString($data['phone']),
            'locale' => $data['locale'] ?? 'en',
        ];

        return $this->create($userData);
    }

    /**
     * Find user by email
     * 
     * @param string $email
     * @return User|null
     */
    public function findByEmail(string $email): ?User
    {
        return $this->findBy('email', $email);
    }

    /**
     * Assign role to user
     * 
     * @param User $user
     * @param string $role
     * @return void
     */
    public function assignRole(User $user, string $role): void
    {
        $user->assignRole($role);
    }

    /**
     * Get user with roles and permissions
     * 
     * @param int $id
     * @return User|null
     */
    public function getUserWithRolesAndPermissions(int $id): ?User
    {
        return $this->model
            ->with(['roles', 'permissions', 'college'])
            ->find($id);
    }

    /**
     * Get all users with roles and optional filters
     * 
     * @param array $filters
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAllWithRoles(array $filters = [])
    {
        $query = $this->model->with(['roles', 'college']);

        // Filter by role
        if (!empty($filters['role'])) {
            $query->whereHas('roles', function ($q) use ($filters) {
                $q->where('name', $filters['role']);
            });
        }

        // Filter by college
        if (!empty($filters['college_id'])) {
            $query->where('college_id', $filters['college_id']);
        }

        // Search by name or email
        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('full_name', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('email', 'like', '%' . $filters['search'] . '%');
            });
        }

        // Filter by CS status
        if (isset($filters['is_cs'])) {
            $query->where('is_cs', $filters['is_cs']);
        }

        return $query->paginate($filters['per_page'] ?? 15);
    }

    /**
     * Create user with role assignment
     * 
     * @param array $data
     * @param string $role
     * @return User
     */
    public function createWithRole(array $data, string $role): User
    {
        // Create user with encrypted data
        $user = $this->createUser($data);

        // Assign role using Spatie Permission
        $user->assignRole($role);

        return $user->load('roles');
    }

    /**
     * Update user details
     * 
     * @param int $id
     * @param array $data
     * @return User|null
     */
    public function updateUser(int $id, array $data): ?User
    {
        $user = $this->find($id);

        if (!$user) {
            return null;
        }

        // Prepare update data
        $updateData = [];

        if (isset($data['full_name'])) {
            $updateData['full_name'] = $data['full_name'];
        }

        if (isset($data['email'])) {
            $updateData['email'] = $data['email'];
        }

        if (isset($data['password'])) {
            $updateData['password'] = Hash::make($data['password']);
        }

        if (isset($data['college_id'])) {
            $updateData['college_id'] = $data['college_id'];
        }

        if (isset($data['is_cs'])) {
            $updateData['is_cs'] = $data['is_cs'];
        }

        if (isset($data['national_id'])) {
            $updateData['national_id_encrypted'] = Crypt::encryptString($data['national_id']);
        }

        if (isset($data['phone'])) {
            $updateData['phone_encrypted'] = Crypt::encryptString($data['phone']);
        }

        if (isset($data['locale'])) {
            $updateData['locale'] = $data['locale'];
        }

        $user->update($updateData);

        return $user->fresh(['roles', 'college']);
    }

    /**
     * Delete user (soft delete)
     * 
     * @param int $id
     * @return bool
     */
    public function deleteUser(int $id): bool
    {
        return $this->delete($id);
    }
}
