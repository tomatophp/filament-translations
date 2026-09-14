<?php

use TomatoPHP\FilamentTranslations\Models\Translation;
use TomatoPHP\FilamentTranslations\Services\SaveScan;
use TomatoPHP\FilamentTranslations\Services\Scan;

beforeEach(function () {
    $this->fixtures = realpath(__DIR__ . '/../fixtures/scan');

    config()->set('filament-translations.paths', [$this->fixtures]);

    app('translator')->addLines([
        'messages.welcome' => 'Welcome, :name!',
        'messages.goodbye' => 'Goodbye!',
    ], 'en');
});

it('finds JSON translation strings that are followed by parameters (#53)', function () {
    $scanner = app(Scan::class);
    $scanner->addScannedPath($this->fixtures);

    [$trans, $__] = $scanner->getAllViewFilesWithTranslations();

    expect($__->all())
        ->toContain('Welcome back :name')
        ->toContain('Signed in as :email')
        ->toContain('Plain string')
        ->and($trans->all())
        ->toContain('messages.welcome')
        ->toContain('messages.goodbye')
        ->toContain('filament-translations::translation.label');
});

it('keeps group keys out of the JSON strings so they are not stored twice (#40)', function () {
    $scanner = app(Scan::class);
    $scanner->addScannedPath($this->fixtures);

    [, $__] = $scanner->getAllViewFilesWithTranslations();

    expect($__->all())
        ->not->toContain('messages.goodbye')
        ->not->toContain('filament-translations::translation.label');
});

it('stores each scanned group key once with the text from the language files (#40)', function () {
    (new SaveScan)->save();

    expect(Translation::query()->where('key', 'messages.goodbye')->exists())->toBeFalse()
        ->and(Translation::query()->where('key', 'filament-translations::translation.label')->exists())->toBeFalse();

    $goodbye = Translation::query()
        ->where('namespace', '*')
        ->where('group', 'messages')
        ->where('key', 'goodbye')
        ->sole();

    $label = Translation::query()
        ->where('namespace', 'filament-translations')
        ->where('group', 'translation')
        ->where('key', 'label')
        ->sole();

    expect($goodbye->text['en'])->toBe('Goodbye!')
        ->and($label->text['en'])->toBe('Translations');
});

it('stores JSON strings with parameters under the * group', function () {
    (new SaveScan)->save();

    $line = Translation::query()
        ->where('group', '*')
        ->where('key', 'Welcome back :name')
        ->sole();

    expect($line->text['en'])->toBe('Welcome back :name');
});

it('does not duplicate translations when scanning again', function () {
    (new SaveScan)->save();
    $count = Translation::query()->count();

    (new SaveScan)->save();

    expect(Translation::query()->count())->toBe($count)
        ->and($count)->toBe(6);
});
