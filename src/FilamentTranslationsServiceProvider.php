<?php

namespace TomatoPHP\FilamentTranslations;

use Illuminate\Support\ServiceProvider;
use Filament\Facades\Filament;

class FilamentTranslationsServiceProvider extends ServiceProvider
{
    public function register(): void
    {

        //Register ConfigTomatoPHP file
        $this->mergeConfigFrom(__DIR__.'/../config/filament-translations.php', 'filament-translations');

        //Publish Config
        $this->publishes([
           __DIR__.'/../config/filament-translations.php' => config_path('filament-translations.php'),
        ], 'filament-translations-config');

        //Register Migrations
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        //Publish Migrations
        $this->publishes([
           __DIR__.'/../database/migrations' => database_path('migrations'),
        ], 'filament-translations-migrations');
        //Register views
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'filament-translations');

        //Publish Views
        $this->publishes([
           __DIR__.'/../resources/views' => resource_path('views/vendor/filament-translations'),
        ], 'filament-translations-views');

        //Register Langs
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'filament-translations');

        //Publish Lang
        $this->publishes([
           __DIR__.'/../resources/lang' => app_path('lang/vendor/filament-translations'),
        ], 'filament-translations-lang');

        //Register Routes
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        //Check Show Switcher
//        if (config('filament-translations.show-switcher')) {
//            Filament::serving(function () {
//                if(auth()->user()){
//                    app()->setLocale(auth()->user()->lang);
//                }
//                if(config('filament-translations.languages-switcher-menu.position') === 'navigation'){
//                    Filament::registerNavigationItems([
//                        NavigationItem::make()
//                            ->group(config('filament-translations.languages-switcher-menu.group'))
//                            ->icon(config('filament-translations.languages-switcher-menu.icon'))
//                            ->label(trans('filament-translations::translation.menu'))
//                            ->sort(config('filament-translations.languages-switcher-menu.sort'))
//                            ->url((string)url(config('filament-translations.languages-switcher-menu.url'))),
//                    ]);
//                }
//                else if(config('filament-translations.languages-switcher-menu.position') === 'user'){
//                    Filament::registerUserMenuItems([
//                        UserMenuItem::make()
//                            ->icon(config('filament-translations.languages-switcher-menu.icon'))
//                            ->label(trans('filament-translations::translation.menu'))
//                            ->sort(config('filament-translations.languages-switcher-menu.sort'))
//                            ->url((string)url(config('filament-translations.languages-switcher-menu.url'))),
//                    ]);
//                }
//
//                Filament::registerNavigationGroups([
//                    config('filament-translations.languages-switcher-menu.group')
//                ]);
//            });
//        }


    }

    public function boot(): void
    {
        //you boot methods here
    }
}
