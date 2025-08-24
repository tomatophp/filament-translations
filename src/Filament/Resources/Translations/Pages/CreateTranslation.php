<?php

namespace TomatoPHP\FilamentTranslations\Filament\Resources\Translations\Pages;

use Filament\Panel;
use Filament\Resources\Pages\CreateRecord;
use TomatoPHP\FilamentDeveloperGate\Http\Middleware\DeveloperGateMiddleware;
use TomatoPHP\FilamentTranslations\Facade\FilamentTranslations;
use TomatoPHP\FilamentTranslations\Filament\Resources\Translations\TranslationResource;

class CreateTranslation extends CreateRecord
{
    protected static string $resource = TranslationResource::class;

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
