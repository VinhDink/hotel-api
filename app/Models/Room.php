<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    const ROOM_STATUS_TRUE = true;

    const ROOM_STATUS_FALSE = false;

    const FIELD_NULL = null;

    protected $fillable = [
        'name',
        'type',
        'hour_price',
        'day_price',
        'status',
        'size',
        'balcony',
        'view',
        'smoking',
        'floor',
        'bathtub',
        'image_first',
        'image_second',
        'image_third',
    ];
}
