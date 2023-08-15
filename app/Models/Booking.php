<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Booking extends Model
{
    use HasFactory;

    const ID_LENGTH = 9;

    const CHECKED_STATUS_TRUE = true;

    const CHECKED_STATUS_FALSE = false;

    const IS_CANCEL_TRUE = true;

    const IS_CANCEL_FALSE = false;

    protected $fillable = [
        'guest_id',
        'guest_name',
        'guest_number',
        'room_id',
        'arrive_date',
        'leave_date',
        'is_cancel',
        'checked',
    ];

    /**
     * Get the room that owns the booking.
     */
    public function checkin(): HasOne
    {
        return $this->hasOne(Checkin::class, 'booking_id');
    }
}
