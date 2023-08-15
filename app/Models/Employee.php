<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    const FIRST_SHIFT = 1;

    const SECOND_SHIFT = 2;

    const THIRD_SHIFT = 3;

    const HOUR_SECOND_SHIFT = '16:59';

    const HOUR_FIRST_SHIFT = '8:59';

    const CHECKIN_STATUS_TRUE = 'Active';

    const CHECKIN_STATUS_FALSE = 'Inactive';

    const ROLE_RECEPTIONIST = 'Receptionist';

    protected $fillable = [
        'name',
        'role',
        'status',
        'shift',
        'day_off',
        'salary',
    ];
}
