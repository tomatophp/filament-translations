<?php

namespace TomatoPHP\FilamentTranslations;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Illuminate\View\View;
use Kenepa\TranslationManager\Http\Middleware\SetLanguage;
use Nwidart\Modules\Module;
use TomatoPHP\FilamentTranslations\Http\Middleware\LanguageMiddleware;
use TomatoPHP\FilamentTranslations\Resources\TranslationResource;


class FilamentTranslationsSwitcherPlugin implements Plugin
{

    private bool $isActive = false;

    public function getId(): string
    {
        return 'filament-translations-switcher';
    }

    public function register(Panel $panel): void
    {
        if(class_exists(Module::class) && \Nwidart\Modules\Facades\Module::find('FilamentTranslations')?->isEnabled()){
            $this->isActive = true;
        }
        else {
            $this->isActive = true;
        }

        if($this->isActive) {

            $panel->renderHook(
                config('filament-translations.language_switcher_render_hook'),
                fn(): View => $this->getLanguageSwitcherView()
            );

            $panel->authMiddleware([
                LanguageMiddleware::class,
            ]);
        }
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
