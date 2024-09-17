<?php

namespace TomatoPHP\FilamentTranslations;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Illuminate\View\View;
use Kenepa\TranslationManager\Http\Middleware\SetLanguage;
use Nwidart\Modules\Module;
use TomatoPHP\FilamentTranslations\Http\Middleware\LanguageMiddleware;


class FilamentTranslationsPlugin implements Plugin
{
    public bool $allowGPTScan = false;
    public bool $allowGoogleTranslateScan = false;
    public bool $allowClearTranslations = false;
    public bool $allowCreate = false;

    private bool $isActive = false;

    public function getId(): string
    {
        return 'filament-translations';
    }

    public function register(Panel $panel): void
    {
        if(class_exists(Module::class)){
            if(\Nwidart\Modules\Facades\Module::find('FilamentTranslations')?->isEnabled()){
                $this->isActive = true;
            }
        }
        else {
            $this->isActive = true;
        }

        if($this->isActive) {
            $panel
                ->resources([
                    config('filament-translations.translation_resource'),
                ]);
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
