<?php

namespace App\Repositories\Eloquent;

use App\Models\Track;
use App\Repositories\Interfaces\TrackRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

/**
 * Track Repository
 * 
 * Handles all track-related database operations
 */
class TrackRepository extends BaseRepository implements TrackRepositoryInterface
{
    /**
     * TrackRepository constructor
     * 
     * @param Track $model
     */
    public function __construct(Track $model)
    {
        parent::__construct($model);
    }

    /**
     * Get all tracks with selected columns
     * 
     * @param array $columns
     * @return Collection
     */
    public function getAllTracks(array $columns = ['*']): Collection
    {
        return $this->model->all($columns);
    }

    /**
     * Get track with courses count
     * 
     * @param int $id
     * @return Track|null
     */
    public function getTrackWithCoursesCount(int $id): ?Track
    {
        $track = $this->find($id);

        if ($track) {
            $track->loadCount('courses');
        }

        return $track;
    }
}
