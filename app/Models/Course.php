<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Course Model
 * 
 * Represents courses in the learning platform
 */
class Course extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'title',
        'description',
        'track_id',
        'start_date',
        'end_date',
        'capacity',
        'status',
        'visibility',
        'is_enrollable',
        'waitlist_enabled',
        'instructor_id',
        'created_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_enrollable' => 'boolean',
        'waitlist_enabled' => 'boolean',
    ];

    /**
     * Get the track this course belongs to
     * 
     * @return BelongsTo
     */
    public function track(): BelongsTo
    {
        return $this->belongsTo(Track::class);
    }

    /**
     * Get the instructor of this course
     * 
     * @return BelongsTo
     */
    public function instructor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    /**
     * Get the user who created this course
     * 
     * @return BelongsTo
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the enrollments for the course
     */
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    /**
     * Get the sessions for the course
     */
    public function sessions()
    {
        return $this->hasMany(Session::class);
    }
}
