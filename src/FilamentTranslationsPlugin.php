<?php

namespace TomatoPHP\FilamentTranslations;

use Filament\Contracts\Plugin;
use Filament\Panel;
use TomatoPHP\FilamentTranslations\Filament\Resources\TranslationResource\Actions\Components\ClearAction;
use TomatoPHP\FilamentTranslations\Filament\Resources\TranslationResource\Actions\Components\CreateAction;
use TomatoPHP\FilamentTranslations\Filament\Resources\TranslationResource\Actions\Components\ScanAction;
use TomatoPHP\FilamentTranslations\Filament\Resources\TranslationResource\Actions\ManagePageActions;
use TomatoPHP\FilamentTranslations\Filament\Resources\TranslationResource\Table\HeaderActions\ExportAction;
use TomatoPHP\FilamentTranslations\Filament\Resources\TranslationResource\Table\HeaderActions\ImportAction;
use TomatoPHP\FilamentTranslations\Filament\Resources\TranslationResource\Table\TranslationHeaderActions;

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
            config('filament-translations.translation_resource'),
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
            ManagePageActions::register(ScanAction::make());
        }

        if (filament('filament-translations')->allowClearTranslations) {
            ManagePageActions::register(ClearAction::make());
        }

        if (filament('filament-translations')->allowCreate) {
            ManagePageActions::register(CreateAction::make());
        }
    }

    public static function make(): FilamentTranslationsPlugin
    {
        return new FilamentTranslationsPlugin;
    }
}
