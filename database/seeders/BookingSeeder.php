<?php

namespace Database\Seeders;

use App\Models\Booking;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bookingRandomNumber = rand(1, 100);
        $randomNumber = rand(1, 100);
        $randomPhone = rand(100000000, 999999999);

        Booking::insert([
            'id' => $bookingRandomNumber,
            'guest_name' => Str::random(9),
            'guest_number' => $randomPhone,
            'room_id' => 'Room_'.$randomNumber,
            'checked' => false,
        ]);
    }
}
