<?php

namespace App\Jobs;

use App\Models\Room;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportDataFromCsv implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $csvPath = storage_path('app/room_data/data.csv');
        $file = fopen($csvPath, 'r');
        $roomData = [];
        //read file
        while (($datas = fgetcsv($file)) !== false) {
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

        fclose($file);
        Room::insert($roomData);
    }
}
