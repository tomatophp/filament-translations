<?php

namespace TomatoPHP\FilamentTranslations;

use Filament\Panel;
use Illuminate\Support\ServiceProvider;


class FilamentTranslationsPlugin extends ServiceProvider
{
    public function getId(): string
    {
        return 'filament-translations';
    }

    public function register(Panel $panel): void
    {
        if(!config('filament-users.publish_resource')){
            $panel
                ->resources([

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
}
