<?php

namespace App\Repositories\Eloquent;

use App\Models\College;
use App\Repositories\Interfaces\CollegeRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

/**
 * College Repository
 * 
 * Handles all college-related database operations
 */
class CollegeRepository extends BaseRepository implements CollegeRepositoryInterface
{
    /**
     * CollegeRepository constructor
     * 
     * @param College $model
     */
    public function __construct(College $model)
    {
        parent::__construct($model);
    }

    /**
     * Get all colleges with selected columns
     * 
     * @param array $columns
     * @return Collection
     */
    public function getAllColleges(array $columns = ['*']): Collection
    {
        return $this->model->all($columns);
    }
}
