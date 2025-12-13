<?php

namespace App\Repositories\Interfaces;

use App\Models\College;
use Illuminate\Database\Eloquent\Collection;

/**
 * College Repository Interface
 * 
 * Defines college-specific operations
 */
interface CollegeRepositoryInterface extends RepositoryInterface
{
    /**
     * Get all colleges with selected columns
     * 
     * @param array $columns
     * @return Collection
     */
    public function getAllColleges(array $columns = ['*']): Collection;
}
