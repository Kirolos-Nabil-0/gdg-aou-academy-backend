<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

/**
 * Certificate Model
 * 
 * Represents generated certificates for course completion
 */
class Certificate extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'user_id',
        'course_id',
        'certificate_number',
        'file_url',
        'status',
        'criteria_snapshot',
        'issued_by',
        'issued_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'issued_at' => 'datetime',
        'criteria_snapshot' => 'array',
    ];

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        // Generate unique certificate number on creation
        static::creating(function ($certificate) {
            if (empty($certificate->certificate_number)) {
                $certificate->certificate_number = 'CERT-' . strtoupper(Str::random(10));
            }
        });
    }

    /**
     * Get the user this certificate belongs to
     * 
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the course this certificate is for
     * 
     * @return BelongsTo
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the download URL for the certificate
     * 
     * @return string|null
     */
    public function getFileUrlAttribute()
    {
        return url("/api/certificates/course/{$this->course_id}/download");
    }
}
