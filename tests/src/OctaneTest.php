<?php

use Filament\Facades\Filament;
use TomatoPHP\FilamentTranslations\Facade\FilamentTranslations;
use TomatoPHP\FilamentTranslations\Filament\Resources\Translations\Pages\ListTranslations;
use TomatoPHP\FilamentTranslations\Filament\Resources\Translations\Pages\ManageTranslations;
use TomatoPHP\FilamentTranslations\Filament\Resources\Translations\Tables\TranslationHeaderActions;

use function Pest\Livewire\livewire;

/**
 * Under Laravel Octane the process (static properties and singletons) survives between requests
 * while the panel, and so the plugin, boots again on every request (#46).
 */
function bootPluginAgain(int $times): void
{
    $panel = Filament::getPanel('admin');

    foreach (range(1, $times) as $ignored) {
        $panel->getPlugin('filament-translations')->boot($panel);
    }
}

it('does not duplicate the table header actions when the plugin boots on every request (#46)', function () {
    bootPluginAgain(3);

    $names = collect(TranslationHeaderActions::make())->map(fn ($action) => $action->getName());

    expect($names->all())->toBe(['import', 'export']);
});

it('does not duplicate the page actions when the plugin boots on every request (#46)', function (string $page) {
    bootPluginAgain(3);

    $names = collect(FilamentTranslations::getActions($page))->map(fn ($action) => $action->getName());

    expect($names->duplicates()->all())->toBe([])
        ->and($names->all())->toContain('scan', 'clear', 'create');
})->with([
    'list page' => ListTranslations::class,
    'manage page' => ManageTranslations::class,
]);

it('renders the page once per action after repeated boots (#46)', function () {
    bootPluginAgain(3);

    livewire(ManageTranslations::class)
        ->assertSuccessful()
        ->assertActionExists('scan')
        ->assertActionExists('clear');
});
