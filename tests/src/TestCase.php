<?php

namespace TomatoPHP\FilamentTranslations\Tests;

use BladeUI\Heroicons\BladeHeroiconsServiceProvider;
use BladeUI\Icons\BladeIconsServiceProvider;
use Filament\Actions\ActionsServiceProvider;
use Filament\FilamentServiceProvider;
use Filament\Forms\FormsServiceProvider;
use Filament\Infolists\InfolistsServiceProvider;
use Filament\Notifications\NotificationsServiceProvider;
use Filament\Support\SupportServiceProvider;
use Filament\Tables\TablesServiceProvider;
use Filament\Widgets\WidgetsServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Orchestra\Testbench\TestCase as BaseTestCase;
use RyanChandler\BladeCaptureDirective\BladeCaptureDirectiveServiceProvider;
use TomatoPHP\FilamentTranslationComponent\FilamentTranslationComponentServiceProvider;
use TomatoPHP\FilamentTranslations\FilamentTranslationsServiceProvider;
use TomatoPHP\FilamentTranslations\Tests\Models\User;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;
    use WithWorkbench;

    protected function defineDatabaseMigrations(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
    }

    protected function getPackageProviders($app): array
    {
        return [
            ActionsServiceProvider::class,
            BladeCaptureDirectiveServiceProvider::class,
            BladeHeroiconsServiceProvider::class,
            BladeIconsServiceProvider::class,
            FilamentServiceProvider::class,
            FormsServiceProvider::class,
            InfolistsServiceProvider::class,
            LivewireServiceProvider::class,
            NotificationsServiceProvider::class,
            SupportServiceProvider::class,
            TablesServiceProvider::class,
            WidgetsServiceProvider::class,
            FilamentTranslationComponentServiceProvider::class,
            FilamentTranslationsServiceProvider::class,
            AdminPanelProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app): void
    {
        $app['config']->set('filament-translations.use_queue_on_scan', false);
        $app['config']->set('database.default', 'testing');
        $app['config']->set('auth.guards.testing.driver', 'session');
        $app['config']->set('auth.guards.testing.provider', 'testing');
        $app['config']->set('auth.providers.testing.driver', 'eloquent');
        $app['config']->set('auth.providers.testing.model', User::class);

        $app['config']->set('filament-translations.paths', [
            __DIR__ . '/../../vendor/orchestra/testbench-core/laravel',
        ]);

        $app['config']->set('view.paths', [
            ...$app['config']->get('view.paths'),
            __DIR__ . '/../resources/views',
        ]);
    }
}
