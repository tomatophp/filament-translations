<?php

namespace TomatoPHP\FilamentTranslations;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use TomatoPHP\FilamentTranslations\Console\FilamentTranslationsInstall;
use TomatoPHP\FilamentTranslations\Console\ImportCommand;
use TomatoPHP\FilamentTranslations\Console\ScanPath;
use TomatoPHP\FilamentTranslations\Models\Translation;
use TomatoPHP\FilamentTranslations\Services\FilamentTranslationsServices;

class FilamentTranslationsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton('filament-translations', function () {
            return new FilamentTranslationsServices;
        });

        // Register ConfigTomatoPHP file
        $this->mergeConfigFrom(__DIR__ . '/../config/filament-translations.php', 'filament-translations');

        // Publish Config
        $this->publishes([
            __DIR__ . '/../config/filament-translations.php' => config_path('filament-translations.php'),
        ], 'filament-translations-config');

        // Register Migrations
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        // Publish Migrations
        $this->publishes([
            __DIR__ . '/../database/migrations' => database_path('migrations'),
        ], 'filament-translations-migrations');
        // Register views
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'filament-translations');

        // Publish Views
        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/filament-translations'),
        ], 'filament-translations-views');

        // Register Langs
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'filament-translations');

        // Publish Lang
        $this->publishes([
            __DIR__ . '/../resources/lang' => base_path('lang/vendor/filament-translations'),
        ], 'filament-translations-lang');

        // Register Routes
        //        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

        $this->commands([
            FilamentTranslationsInstall::class,
            ImportCommand::class,
            ScanPath::class,
        ]);

    }

    public function boot(): void
    {
        Config::set('filament-translation-component.languages', Config::get('filament-translations.locals'));

        $this->registerPolicy();
    }

    /**
     * Laravel only auto-discovers policies next to the model's namespace, so a policy for this
     * package's model is never found on its own (#44). Register the configured one, or the
     * conventional App\Policies\TranslationPolicy when the app has it.
     */
    protected function registerPolicy(): void
    {
        $policy = Config::get('filament-translations.policy');

        if (! $policy && Gate::getPolicyFor(Translation::class) === null && class_exists('App\\Policies\\TranslationPolicy')) {
            $policy = 'App\\Policies\\TranslationPolicy';
        }

        if ($policy) {
            Gate::policy(Translation::class, $policy);
        }
    }
}
