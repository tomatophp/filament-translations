<?php

namespace TomatoPHP\FilamentTranslations;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Illuminate\View\View;
use Kenepa\TranslationManager\Http\Middleware\SetLanguage;
use TomatoPHP\FilamentTranslations\Http\Middleware\LanguageMiddleware;


class FilamentTranslationsPlugin implements Plugin
{
    public bool $allowGPTScan = false;
    public bool $allowGoogleTranslateScan = false;
    public bool $allowClearTranslations = false;
    public bool $allowCreate = false;

    public function getId(): string
    {
        return 'filament-translations';
    }

    public function register(Panel $panel): void
    {
        $panel
            ->resources([
                config('filament-translations.translation_resource'),
            ]);

        if (config('filament-translations.language_switcher')) {
            $panel->renderHook(
                config('filament-translations.language_switcher_render_hook'),
                fn (): View => $this->getLanguageSwitcherView()
            );

        }
    }

    public function allowGPTScan(bool $allowGPTScan=true): self
    {
        $this->allowGPTScan = $allowGPTScan;
        return $this;
    }

    public function allowGoogleTranslateScan(bool $allowGoogleTranslateScan=true): self
    {
        $this->allowGoogleTranslateScan = $allowGoogleTranslateScan;
        return $this;
    }

    public function allowClearTranslations(bool $allowClearTranslations=true): self
    {
        $this->allowClearTranslations = $allowClearTranslations;
        return $this;
    }

    public function allowCreate(bool $allowCreate=true): self
    {
        $this->allowCreate = $allowCreate;
        return $this;
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
