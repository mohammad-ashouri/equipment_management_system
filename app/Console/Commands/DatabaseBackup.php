<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class DatabaseBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'database:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create copy of mysql dump for existing database.';

    /**
     * Execute the console command.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
//        $filename = "backup-" . Carbon::now()->format('Y-m-d-H-i-s') . ".sql";
//        $table = new \App\Models\DatabaseBackup();
//        $folderName = md5(rand(5648, 10005484));
//        // Create backup folder and set permission if not exist.
//        $storageAt = storage_path() . "/app/public/backup/" . $folderName . '/';
//        $table->filename = $folderName . '/' . $filename;
//        $table->creator = session('id');
//        $table->save();
//        if (!File::exists($storageAt)) {
//            File::makeDirectory($storageAt, 0775, true, true);
//        }
//        $command = "" . env('DB_DUMP_PATH', 'mysqldump') . " --user=" . env('DB_USERNAME') . " --password=" . env('DB_PASSWORD') . " --host=" . env('DB_HOST') . " " . env('DB_DATABASE') . " > " . $storageAt . $filename;
//        $returnVar = NULL;
//        $output = NULL;
//        exec($command, $output, $returnVar);


        $filename = "backup-" . Carbon::now()->format('Y-m-d-H-i-s') . ".sql";
        $table = new \App\Models\DatabaseBackup();
        $folderName = md5(rand(5648, 10005484));
        $storageAt = storage_path() . "/app/public/backup/" . $folderName . '/';
        $table->filename = $folderName . '/' . $filename;
        $table->creator = session('id');
        $table->save();

        if (!File::exists($storageAt)) {
            File::makeDirectory($storageAt, 0775, true, true);
        }

        $command = "" . env('DB_DUMP_PATH', 'pg_dump') .
            " --dbname=postgresql://" . env('DB_USERNAME') .
            ":" . env('DB_PASSWORD') .
            "@" . env('DB_HOST') .
            "/" . env('DB_DATABASE') .
            " -F p > " . $storageAt . $filename;

        $returnVar = NULL;
        $output = NULL;
        exec($command . " 2>&1", $output, $returnVar);

        if ($returnVar !== 0) {
            Log::error('pg_dump error: ' . implode("\n", $output));
            // می‌توانید همچنین پیام خطا را به کاربر نشان دهید یا به طریقی ثبت کنید.
        }
    }
}
