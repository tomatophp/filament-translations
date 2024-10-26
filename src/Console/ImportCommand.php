<?php

namespace TomatoPHP\FilamentTranslations\Console;

use Illuminate\Console\Command;
use TomatoPHP\FilamentTranslations\Services\SaveScan;

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
        if (config('filament-translations.path_to_custom_import_command')) {
            $response = spin(
                function () {
                    $command = config('filament-translations.path_to_custom_import_command');
                    $command = new $command;
                    $command->handle();
                },
                'Fetching keys...'
            );

            $this->info('Done importing');

            return;
        }

        $response = spin(
            function () {
                $scan = new SaveScan;
                $scan->save();
            },
            'Fetching keys...'
        );

        $this->info('Done importing');
    }
}
