<?php

namespace TomatoPHP\FilamentTranslations\Console;

use Illuminate\Console\Command;
use TomatoPHP\FilamentTranslations\Services\Manager;

class ImportCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'filament-translations:import 
                                {--R|replace : Force replace values in database}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import translations from the language files';

    protected Manager $manager;

    public function __construct()
    {
        $this->manager = resolve(Manager::class);
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $replace = $this->option('replace');
        $counter = $this->manager->importTranslations($replace);
        $this->info('Done importing, processed '.$counter.' items!');
    }

}
