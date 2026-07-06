<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RideEnquiry extends Model
{
    protected $fillable = [
        'user_id',
        'driver_id',
        'latitude',
        'longitude',
        'location'
    ];

    /**
     * Get the passenger (user) who made the enquiry.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the driver who was called/enquired.
     */
    public function driver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'driver_id');
    }
}
