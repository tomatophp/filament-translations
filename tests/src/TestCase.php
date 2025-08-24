<?php

namespace TomatoPHP\FilamentTranslations\Tests;

use BladeUI\Heroicons\BladeHeroiconsServiceProvider;
use BladeUI\Icons\BladeIconsServiceProvider;
use Filament\Actions\ActionsServiceProvider;
use Filament\Actions\CreateAction;
use Filament\Actions\ExportAction;
use Filament\Actions\ImportAction;
use Filament\Facades\Filament;
use Filament\FilamentServiceProvider;
use Filament\Forms\FormsServiceProvider;
use Filament\Infolists\InfolistsServiceProvider;
use Filament\Notifications\NotificationsServiceProvider;
use Filament\Panel;
use Filament\Schemas\SchemasServiceProvider;
use Filament\Support\SupportServiceProvider;
use Filament\Tables\TablesServiceProvider;
use Filament\Widgets\WidgetsServiceProvider;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\Attributes\WithEnv;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Orchestra\Testbench\TestCase as BaseTestCase;
use RyanChandler\BladeCaptureDirective\BladeCaptureDirectiveServiceProvider;
use TomatoPHP\FilamentDeveloperGate\Actions\DeveloperLogoutAction;
use TomatoPHP\FilamentTranslationComponent\FilamentTranslationComponentServiceProvider;
use TomatoPHP\FilamentTranslations\Facade\FilamentTranslations;
use TomatoPHP\FilamentTranslations\Filament\Resources\Translations\Actions\ClearAction;
use TomatoPHP\FilamentTranslations\Filament\Resources\Translations\Actions\ScanAction;
use TomatoPHP\FilamentTranslations\Filament\Resources\Translations\Pages\ListTranslations;
use TomatoPHP\FilamentTranslations\Filament\Resources\Translations\Pages\ManageTranslations;
use TomatoPHP\FilamentTranslations\Filament\Resources\Translations\Tables\TranslationHeaderActions;
use TomatoPHP\FilamentTranslations\FilamentTranslationsServiceProvider;
use TomatoPHP\FilamentTranslations\Tests\Models\User;

#[WithEnv('DB_CONNECTION', 'testing')]
abstract class TestCase extends BaseTestCase
{
    use LazilyRefreshDatabase;
    use WithWorkbench;

    public ?Panel $panel;

    protected function setUp(): void
    {
        parent::setUp();

        $this->panel = Filament::getCurrentOrDefaultPanel();

        if (config('filament-translations.import_enabled')) {
            TranslationHeaderActions::register(ImportAction::make());
        }

        if (config('filament-translations.export_enabled')) {
            TranslationHeaderActions::register(ExportAction::make());
        }

        if (config('filament-translations.scan_enabled')) {
            FilamentTranslations::register(ScanAction::make(), ListTranslations::class);
            FilamentTranslations::register(ScanAction::make(), ManageTranslations::class);
        }

        if (filament('filament-translations')->allowClearTranslations) {
            FilamentTranslations::register(ClearAction::make(), ListTranslations::class);
            FilamentTranslations::register(ClearAction::make(), ManageTranslations::class);
        }

        if (filament('filament-translations')->allowCreate) {
            FilamentTranslations::register(CreateAction::make(), ListTranslations::class);
            FilamentTranslations::register(CreateAction::make(), ManageTranslations::class);
        }

        if (config('filament-translations.use_developer_gate')) {
            FilamentTranslations::register(DeveloperLogoutAction::make(), ListTranslations::class);
            FilamentTranslations::register(DeveloperLogoutAction::make(), ManageTranslations::class);
        }
    }

    protected function defineDatabaseMigrations(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
    }

    protected function getPackageProviders($app): array
    {
        $providers = [
            ActionsServiceProvider::class,
            BladeCaptureDirectiveServiceProvider::class,
            BladeHeroiconsServiceProvider::class,
            BladeIconsServiceProvider::class,
            FilamentServiceProvider::class,
            FormsServiceProvider::class,
            SchemasServiceProvider::class,
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

        sort($providers);

        return $providers;
    }

    public function getEnvironmentSetUp($app): void
    {
        $app['config']->set('filament-translations.use_queue_on_scan', false);
        $app['config']->set('database.default', 'testing');
        $app['config']->set('auth.guards.testing.driver', 'session');
        $app['config']->set('auth.guards.testing.provider', 'testing');
        $app['config']->set('auth.providers.testing.driver', 'eloquent');
        $app['config']->set('auth.providers.testing.model', User::class);
        $app['config']->set('filament-translations.scan_enabled', true);
        $app['config']->set('filament-translations.scan_enabled', true);

        $app['config']->set('filament-translations.paths', [
            __DIR__ . '/../../vendor/orchestra/testbench-core/laravel',
        ]);

        $app['config']->set('view.paths', [
            ...$app['config']->get('view.paths'),
            __DIR__ . '/../resources/views',
        ]);

        $app['config']->set('filament-translations.translation_resource', \TomatoPHP\FilamentTranslations\Filament\Resources\Translations\TranslationResource::class);
    }
}
