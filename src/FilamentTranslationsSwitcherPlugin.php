<?php

namespace TomatoPHP\FilamentTranslations;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Illuminate\View\View;
use Kenepa\TranslationManager\Http\Middleware\SetLanguage;
use TomatoPHP\FilamentTranslations\Http\Middleware\LanguageMiddleware;
use TomatoPHP\FilamentTranslations\Resources\TranslationResource;


class FilamentTranslationsSwitcherPlugin implements Plugin
{
    public function getId(): string
    {
        return 'filament-translations-switcher';
    }

    public function register(Panel $panel): void
    {
        $panel->renderHook(
            config('filament-translations.language_switcher_render_hook'),
            fn (): View => $this->getLanguageSwitcherView()
        );

        $panel->authMiddleware([
            LanguageMiddleware::class,
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


    /**
     * Returns a View object that renders the language switcher component.
     *
     * @return \Illuminate\Contracts\View\View The View object that renders the language switcher component.
     */
    private function getLanguageSwitcherView(): View
    {
        $locales = config('filament-translations.locals');
        $currentLocale = app()->getLocale();
        $currentLanguage = collect($locales)->firstWhere('code', $currentLocale);
        $otherLanguages = $locales;
        $showFlags = config('filament-translations.show_flags');

        return view('filament-translations::language-switcher', compact(
            'otherLanguages',
            'currentLanguage',
            'showFlags',
        ));
    }
}
