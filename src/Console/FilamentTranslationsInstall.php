<?php

namespace TomatoPHP\FilamentTranslations\Console;

use Illuminate\Console\Command;

class FilamentTranslationsInstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'filament-translations:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'install package and publish assets';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Running migrations');
        $this->call('migrate', ['--force' => true]);

        $this->info('Scanning for translations');
        $this->call('filament-translations:import');

        $this->info('Filament Translations Manager installed successfully.');

        return self::SUCCESS;
    }
}
