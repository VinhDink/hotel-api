<?php

namespace App\Jobs;

use App\Models\Checkin;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ExportDataToCsv implements ShouldQueue
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
        $rawData = Checkin::with('booking')->get()->toArray();
        $data = [];

        //for in range
        for ($i = 0; $i < count($rawData); $i++) {
            $array = [
                $rawData[$i]['booking_id'],
                $rawData[$i]['booking']['guest_name'],
                $rawData[$i]['booking']['guest_number'],
                $rawData[$i]['checkin_time'],
                $rawData[$i]['checkout_time'],
                $rawData[$i]['total_price'],
                $rawData[$i]['booking']['room_id'],
            ];
            array_push($data, $array);
        }

        $csvPath = storage_path('/app/export/data.csv');
        $file = fopen($csvPath, 'w');

        fputcsv($file, ['booking_id', 'guest_name', 'guest_number', 'checkin_time', 'checkout_time', 'total_price', 'room_id']);
        foreach ($data as $row) {
            fputcsv($file, $row);
        }

        fclose($file);
    }
}
