<?php

namespace TomatoPHP\FilamentTranslations\Filament\Resources\Translations\Pages;

use Filament\Panel;
use Filament\Resources\Pages\ManageRecords;
use TomatoPHP\FilamentDeveloperGate\Http\Middleware\DeveloperGateMiddleware;
use TomatoPHP\FilamentTranslations\Facade\FilamentTranslations;
use TomatoPHP\FilamentTranslations\Filament\Resources\Translations\TranslationResource;

class ManageTranslations extends ManageRecords
{
    protected static string $resource = TranslationResource::class;

    public function getTitle(): string
    {
        return trans('filament-translations::translation.title.home');
    }

    public static function getRouteMiddleware(Panel $panel): string | array
    {
        if (config('filament-translations.use_developer_gate')) {
            return [
                'auth',
                'verified',
                DeveloperGateMiddleware::class,
            ];
        }

        return [];
    }

    public function getHeaderActions(): array
    {
        return FilamentTranslations::getActions(self::class);
    }
}
