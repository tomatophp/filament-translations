<?php

namespace TomatoPHP\FilamentTranslations;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Illuminate\View\View;
use Kenepa\TranslationManager\Http\Middleware\SetLanguage;
use TomatoPHP\FilamentTranslations\Http\Middleware\LanguageMiddleware;
use TomatoPHP\FilamentTranslations\Resources\TranslationResource;


class FilamentTranslationsPlugin implements Plugin
{
    public function getId(): string
    {
        return 'filament-translations';
    }

    public function register(Panel $panel): void
    {
        $panel->resources([
            TranslationResource::class
        ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): static
    {
        return new static();
    }
}
