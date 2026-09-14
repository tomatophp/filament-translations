<?php

use Filament\Actions\Testing\TestAction;
use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use TomatoPHP\FilamentTranslations\Filament\Resources\Translations\Pages\ManageTranslations;
use TomatoPHP\FilamentTranslations\Services\ExcelImportExportService;
use TomatoPHP\FilamentTranslations\Tests\Models\Translation;
use TomatoPHP\FilamentTranslations\Tests\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Livewire\livewire;

beforeEach(function () {
    actingAs(User::factory()->create());
});

it('exports the translations to an excel file', function () {
    Translation::factory()->count(3)->create();

    $response = ExcelImportExportService::export();

    expect($response)->toBeInstanceOf(BinaryFileResponse::class)
        ->and($response->getFile()->getSize())->toBeGreaterThan(0);
});

it('downloads the export from the translations table', function () {
    Translation::factory()->count(3)->create();

    livewire(ManageTranslations::class)
        ->callAction(TestAction::make('export')->table())
        ->assertFileDownloaded();
});

it('imports translated texts and keeps the locales left empty in the file', function () {
    $line = Translation::factory()->create([
        'text' => ['en' => 'Hello', 'ar' => 'Marhaba'],
    ]);

    $csv = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'filament-translations-' . uniqid() . '.csv';
    file_put_contents($csv, "id,key,English,Arabic,French\n{$line->id},{$line->key},Hello there,,Bonjour\n");

    ExcelImportExportService::import(new UploadedFile($csv, 'translations.csv', 'text/csv', null, true));
    @unlink($csv);

    expect($line->refresh()->text)->toMatchArray([
        'en' => 'Hello there',
        'ar' => 'Marhaba',
        'fr' => 'Bonjour',
    ]);
});

it('skips rows whose translation no longer exists', function () {
    $csv = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'filament-translations-' . uniqid() . '.csv';
    file_put_contents($csv, "id,key,English\n999999,missing,Missing\n");

    ExcelImportExportService::import(new UploadedFile($csv, 'translations.csv', 'text/csv', null, true));
    @unlink($csv);

    expect(Translation::query()->count())->toBe(0);
});
