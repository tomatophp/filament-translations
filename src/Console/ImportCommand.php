<?php

namespace TomatoPHP\FilamentTranslations\Console;

use Illuminate\Console\Command;
use TomatoPHP\FilamentTranslations\Services\Manager;
use TomatoPHP\FilamentTranslations\Services\SaveScan;
use function Laravel\Prompts\progress;
use function Laravel\Prompts\spin;

class ImportCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'filament-translations:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import translations from the language files';


    /**
     * Execute the console command.
     */
    public function handle()
    {
        $response = spin(
            function (){
                $scan = new SaveScan();
                $scan->save();
            },
            'Fetching keys...'
        );

        $this->info('Done importing');
    }

}
