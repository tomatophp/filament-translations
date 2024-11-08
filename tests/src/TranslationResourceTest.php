<?php

namespace TomatoPHP\FilamentTranslations\Tests;

use TomatoPHP\FilamentTranslations\Filament\Resources\TranslationResource;
use TomatoPHP\FilamentTranslations\Tests\Models\Translation;
use TomatoPHP\FilamentTranslations\Tests\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\get;
use function Pest\Livewire\livewire;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNotEquals;

beforeEach(function () {
    actingAs(User::factory()->create());
});

it('can render translation resource', function () {
    get(TranslationResource::getUrl())->assertSuccessful();
});

it('can list translations', function () {
    Translation::query()->delete();
    $translations = Translation::factory()->count(10)->create();

    livewire(\TomatoPHP\FilamentTranslations\Filament\Resources\TranslationResource\Pages\ListTranslations::class)
        ->loadTable()
        ->assertCanSeeTableRecords($translations)
        ->assertCountTableRecords(10);
});

it('can render user key/text column in table', function () {
    Translation::factory()->count(10)->create();

    livewire(\TomatoPHP\FilamentTranslations\Filament\Resources\TranslationResource\Pages\ListTranslations::class)
        ->loadTable()
        ->assertCanRenderTableColumn('key')
        ->assertCanRenderTableColumn('text');
});

it('can render translations list page', function () {
    livewire(\TomatoPHP\FilamentTranslations\Filament\Resources\TranslationResource\Pages\ListTranslations::class)->assertSuccessful();
});


it('can render translation create page', function () {
    if (filament('filament-translations')->allowCreate) {
        if (config('filament-translations.modal')) {
            livewire(TranslationResource\Pages\ManageTranslations::class)
                ->mountAction('create')
                ->assertSuccessful();
        } else {
            get(TranslationResource::getUrl('create'))->assertSuccessful();
        }
    }
});

it('can render translation scan button', function () {
    if (config('filament-translations.modal')) {
        livewire(TranslationResource\Pages\ManageTranslations::class)
            ->mountAction('scan')
            ->assertSuccessful();
    } else {
        livewire(\TomatoPHP\FilamentTranslations\Filament\Resources\TranslationResource\Pages\ListTranslations::class)
            ->mountAction('scan')
            ->assertSuccessful();
    }
});

it('can run scan', function () {
    Translation::query()->delete();

    if (config('filament-translations.modal')) {
        livewire(TranslationResource\Pages\ManageTranslations::class)
            ->callAction('scan')
            ->assertSuccessful();
    } else {
        livewire(\TomatoPHP\FilamentTranslations\Filament\Resources\TranslationResource\Pages\ListTranslations::class)
            ->callAction('scan')
            ->assertSuccessful();
    }

    assertNotEquals(Translation::query()->count(), 0);
});

it('can render translation clear button', function () {
    Translation::factory()->count(10)->create();

    if (filament('filament-translations')->allowClearTranslations) {
        if (config('filament-translations.modal')) {
            livewire(TranslationResource\Pages\ManageTranslations::class)
                ->callAction('clear')
                ->assertSuccessful();
        } else {
            livewire(\TomatoPHP\FilamentTranslations\Filament\Resources\TranslationResource\Pages\ListTranslations::class)
                ->callAction('clear')
                ->assertSuccessful();
        }

        assertEquals(Translation::query()->count(), 0);
    }
});

it('can perform clear translation clear', function () {
    if (filament('filament-translations')->allowClearTranslations) {
        if (config('filament-translations.modal')) {
            livewire(TranslationResource\Pages\ManageTranslations::class)
                ->mountAction('clear')
                ->assertSuccessful();
        } else {
            livewire(\TomatoPHP\FilamentTranslations\Filament\Resources\TranslationResource\Pages\ListTranslations::class)
                ->mountAction('clear')
                ->assertSuccessful();
        }
    }
});

it('can create new translation', function () {
    $newData = Translation::factory()->make();

    livewire(TranslationResource\Pages\CreateTranslation::class)
        ->fillForm([
            'group' => $newData->group,
            'key' => $newData->key,
            'text' => $newData->text,
            'namespace' => $newData->namespace,
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    assertDatabaseHas(Translation::class, [
        'group' => $newData->group,
        'key' => $newData->key,
    ]);
});

it('can validate translation input', function () {
    livewire(TranslationResource\Pages\CreateTranslation::class)
        ->fillForm([
            'group' => null,
            'key' => null,
        ])
        ->call('create')
        ->assertHasFormErrors([
            'group' => 'required',
            'key' => 'required',
        ]);
});

it('can render translation edit page', function () {
    if (config('filament-translations.modal')) {
        livewire(TranslationResource\Pages\ManageTranslations::class, [
            'record' => Translation::factory()->create(),
        ])
            ->mountAction('edit')
            ->assertSuccessful();
    } else {
        get(TranslationResource::getUrl('edit', [
            'record' => Translation::factory()->create(),
        ]))->assertSuccessful();
    }
});

it('can retrieve translation data', function () {
    $translation = Translation::factory()->create();

    livewire(\TomatoPHP\FilamentTranslations\Filament\Resources\TranslationResource\Pages\EditTranslation::class, [
        'record' => $translation->getRouteKey(),
    ])
        ->assertFormSet([
            'group' => $translation->group,
            'key' => $translation->key,
            'text' => $translation->text,
        ]);
});

it('can validate edit translation input', function () {
    $translation = Translation::factory()->create();

    livewire(\TomatoPHP\FilamentTranslations\Filament\Resources\TranslationResource\Pages\EditTranslation::class, [
        'record' => $translation->getRouteKey(),
    ])
        ->fillForm([
            'group' => null,
            'key' => null,
        ])
        ->call('save')
        ->assertHasFormErrors([
            'group' => 'required',
            'key' => 'required',
        ]);
});

it('can save translation data', function () {
    $translation = Translation::factory()->create();
    $newData = Translation::factory()->make();

    livewire(\TomatoPHP\FilamentTranslations\Filament\Resources\TranslationResource\Pages\EditTranslation::class, [
        'record' => $translation->getRouteKey(),
    ])

        ->fillForm([
            'text' => $newData->text,
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    expect($translation->refresh())
        ->text->toBe($newData->text);
});
