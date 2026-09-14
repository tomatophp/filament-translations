<?php

use Illuminate\Support\Facades\File;
use TomatoPHP\FilamentTranslations\Models\Translation;

use function Pest\Laravel\artisan;

beforeEach(function () {
    $this->fixtures = realpath(__DIR__ . '/../fixtures/scan');

    config()->set('filament-translations.paths', [$this->fixtures]);
});

it('imports the scanned translations with the import command', function () {
    artisan('filament-translations:import')->assertSuccessful();

    expect(Translation::query()->where('group', 'messages')->where('key', 'goodbye')->exists())->toBeTrue()
        ->and(Translation::query()->where('group', '*')->where('key', 'Welcome back :name')->exists())->toBeTrue();
});

it('installs the package and imports the translations', function () {
    artisan('filament-translations:install')->assertSuccessful();

    expect(Translation::query()->count())->toBeGreaterThan(0);
});

it('writes the JSON strings of a path to its lang/en.json with the scan command', function () {
    $dir = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'filament-translations-scan-' . uniqid();
    File::copyDirectory($this->fixtures, $dir);

    artisan('filament-translations:scan', ['path' => $dir])->assertSuccessful();

    $json = json_decode(File::get($dir . '/resources/lang/en.json'), true);
    File::deleteDirectory($dir);

    expect($json)
        ->toHaveKey('Welcome back :name')
        ->toHaveKey('Plain string')
        ->not->toHaveKey('messages.goodbye');
});
