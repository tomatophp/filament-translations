<?php

namespace TomatoPHP\FilamentTranslations\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use TomatoPHP\FilamentTranslations\Services\SaveScan;

class ScanJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if (config('filament-translations.path_to_custom_import_command')) {
            $command
                = new config('filament-translations.path_to_custom_import_command');
            $command->handle();
            return;
        }
        
        $saveScan = new SaveScan();
        $saveScan->save();
    }
}
