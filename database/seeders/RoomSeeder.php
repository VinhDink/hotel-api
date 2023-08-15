<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $file = fopen('/Users/vinh/Documents/Kiai/hotel/hotel/database/seeders/RoomData.csv', 'r');
        $row = 0;
        $roomData = [];
        while (($datas = fgetcsv($file)) !== false) {
            $row++;
            if ($row == 1) {
                continue;
            }
            $data = [
                'name' => $datas[0],
                'type' => $datas[1],
                'hour_price' => $datas[2],
                'day_price' => $datas[3],
                'status' => $datas[4],
                'size' => $datas[5],
                'balcony' => $datas[6],
                'view' => $datas[7],
                'smoking' => $datas[8],
                'floor' => $datas[9],
                'bathtub' => $datas[10],
                'image_first' => $datas[11],
                'image_second' => $datas[12],
                'image_third' => $datas[13],
            ];
            array_push($roomData, $data);
        }
        Room::insert($roomData);
    }
}
