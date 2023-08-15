<?php

namespace Database\Seeders;

use App\Models\Checkin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class CheckinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $randomNumber = rand(1, 100);
        $randomDate = Carbon::now()->subDay(random_int(0, 15));
        $price = rand(300, 400);
        Checkin::create([
            'booking_id' => $randomNumber,
            'employee_id' => $randomNumber,
            'checkin_time' => $randomDate,
            'total_price' => $price,
            'status' => '1',
        ]);
    }
}
