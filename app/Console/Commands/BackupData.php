<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\ExportDataToCsv;

class BackupData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:backup-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export checkin data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        ExportDataToCsv::dispatch();

        $url = storage_path('app/export/data.csv');
        $filename = basename($url); 
    
        $savePath = getenv('HOME') . '/Desktop/Data/' . $filename;
    
        file_put_contents($savePath, file_get_contents($url));
    
        $this->info("File downloaded and saved to: $savePath");
    }
}
