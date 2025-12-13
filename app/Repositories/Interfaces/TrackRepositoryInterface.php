<?php

namespace App\Repositories\Interfaces;

use App\Models\Track;
use Illuminate\Database\Eloquent\Collection;

/**
 * Track Repository Interface
 * 
 * Defines track-specific operations
 */
interface TrackRepositoryInterface extends RepositoryInterface
{
    /**
     * Get all tracks with selected columns
     * 
     * @param array $columns
     * @return Collection
     */
    public function getAllTracks(array $columns = ['*']): Collection;

    /**
     * Get track with courses count
     * 
     * @param int $id
     * @return Track|null
     */
    public function getTrackWithCoursesCount(int $id): ?Track;
}
