<?php

namespace App\Repositories\Interfaces;

/**
 * Base Repository Interface
 * 
 * Defines common CRUD operations for all repositories
 */
interface RepositoryInterface
{
    /**
     * Get all records
     * 
     * @param array $columns
     * @return mixed
     */
    public function all(array $columns = ['*']);

    /**
     * Find a record by ID
     * 
     * @param int $id
     * @return mixed
     */
    public function find(int $id);

    /**
     * Create a new record
     * 
     * @param array $data
     * @return mixed
     */
    public function create(array $data);

    /**
     * Update a record
     * 
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function update(int $id, array $data);

    /**
     * Delete a record
     * 
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;

    /**
     * Find by specific column
     * 
     * @param string $column
     * @param mixed $value
     * @return mixed
     */
    public function findBy(string $column, $value);
}
