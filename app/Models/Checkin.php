<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkin extends Model
{
    use HasFactory;

    const CHECKIN_STATUS_TRUE = true;

    const CHECKIN_STATUS_FALSE = false;

    const FIRST_3_HOUR = 3;

    const DIFF_LESS_THAN_1 = 0;

    const ID_EXIST_TRUE = true;

    protected $fillable = [
        'booking_id',
        'employee_id',
        'checkout_time',
        'fee',
        'checkin_time',
        'total_price',
        'status',
    ];

    public function booking()
    {
      return $this->belongsTo(Booking::class);
    }
}
