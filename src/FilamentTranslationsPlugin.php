<?php

namespace TomatoPHP\FilamentTranslations;

use Filament\Contracts\Plugin;
use Filament\Panel;
use TomatoPHP\FilamentDeveloperGate\Actions\DeveloperLogoutAction;
use TomatoPHP\FilamentTranslations\Facade\FilamentTranslations;
use TomatoPHP\FilamentTranslations\Filament\Resources\Translations\Actions\ClearAction;
use TomatoPHP\FilamentTranslations\Filament\Resources\Translations\Actions\CreateAction;
use TomatoPHP\FilamentTranslations\Filament\Resources\Translations\Actions\ScanAction;
use TomatoPHP\FilamentTranslations\Filament\Resources\Translations\Pages\ListTranslations;
use TomatoPHP\FilamentTranslations\Filament\Resources\Translations\Pages\ManageTranslations;
use TomatoPHP\FilamentTranslations\Filament\Resources\Translations\Tables\HeaderActions\ExportAction;
use TomatoPHP\FilamentTranslations\Filament\Resources\Translations\Tables\HeaderActions\ImportAction;
use TomatoPHP\FilamentTranslations\Filament\Resources\Translations\Tables\TranslationHeaderActions;
use TomatoPHP\FilamentTranslations\Filament\Resources\Translations\TranslationResource;

class FilamentTranslationsPlugin implements Plugin
{
    public bool $allowClearTranslations = false;

    public bool $allowCreate = false;

    public function getId(): string
    {
        return 'filament-translations';
    }

    public function register(Panel $panel): void
    {
        $panel->resources([
            config('filament-translations.translation_resource') ?: TranslationResource::class,
        ]);
    }

    public function allowClearTranslations(bool $allowClearTranslations = true): self
    {
        $this->allowClearTranslations = $allowClearTranslations;

        return $this;
    }

    public function allowCreate(bool $allowCreate = true): self
    {
        $this->allowCreate = $allowCreate;

        return $this;
    }

    public function boot(Panel $panel): void
    {

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

    public static function make(): FilamentTranslationsPlugin
    {
        return new FilamentTranslationsPlugin;
    }
}
