<?php

use App\Policies\TranslationPolicy;
use Illuminate\Support\Facades\Gate;
use TomatoPHP\FilamentTranslations\Filament\Resources\Translations\Pages\ManageTranslations;
use TomatoPHP\FilamentTranslations\Filament\Resources\Translations\TranslationResource;
use TomatoPHP\FilamentTranslations\FilamentTranslationsServiceProvider;
use TomatoPHP\FilamentTranslations\Models\Translation;
use TomatoPHP\FilamentTranslations\Tests\Models\User;
use TomatoPHP\FilamentTranslations\Tests\Policies\DenyingTranslationPolicy;
use TomatoPHP\FilamentTranslations\Tests\Policies\ReadOnlyTranslationPolicy;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

beforeEach(function () {
    actingAs(User::factory()->create());
});

function usePolicy(?string $policy): void
{
    config()->set('filament-translations.policy', $policy);

    app()->getProvider(FilamentTranslationsServiceProvider::class)->boot();
}

it('registers the policy set in the config for the translation model (#44)', function () {
    usePolicy(DenyingTranslationPolicy::class);

    expect(Gate::getPolicyFor(Translation::class))->toBeInstanceOf(DenyingTranslationPolicy::class);
});

it('forbids the translations page when the policy denies viewing translations (#44)', function () {
    usePolicy(DenyingTranslationPolicy::class);

    get(TranslationResource::getUrl())->assertForbidden();
});

it('hides the scan, import and clear actions when the policy denies changing translations (#44)', function () {
    usePolicy(ReadOnlyTranslationPolicy::class);

    livewire(ManageTranslations::class)
        ->assertSuccessful()
        ->assertActionHidden('scan')
        ->assertActionHidden('clear');
});

it('keeps the scan and clear actions available without a policy', function () {
    livewire(ManageTranslations::class)
        ->assertActionVisible('scan')
        ->assertActionVisible('clear');
});

it('uses App\Policies\TranslationPolicy when the app defines one (#44)', function () {
    require_once __DIR__ . '/../fixtures/App/Policies/TranslationPolicy.php';

    usePolicy(null);

    expect(Gate::getPolicyFor(Translation::class))->toBeInstanceOf(TranslationPolicy::class);
});
