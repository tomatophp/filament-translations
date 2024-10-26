<?php

use Filament\Facades\Filament;
use TomatoPHP\FilamentTranslations\FilamentTranslationsPlugin;

it('registers plugin', function () {
    $panel = Filament::getCurrentPanel();

    $panel->plugins([
        FilamentTranslationsPlugin::make(),
    ]);

    expect($panel->getPlugin('filament-translations'))
        ->not()
        ->toThrow(Exception::class);
});

it('can modify allow create new translations', function ($condition) {
    $plugin = FilamentTranslationsPlugin::make()
        ->allowCreate($condition);

    expect($plugin->allowCreate)->toBe($condition);
})->with([
    false,
    fn () => true,
]);

it('can modify allow clear all translations', function ($condition) {
    $plugin = FilamentTranslationsPlugin::make()
        ->allowClearTranslations($condition);

    expect($plugin->allowClearTranslations)->toBe($condition);
})->with([
    false,
    fn () => true,
]);
