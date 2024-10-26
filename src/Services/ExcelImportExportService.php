<?php

namespace TomatoPHP\FilamentTranslations\Services;

use Filament\Notifications\Notification;
use Illuminate\Http\UploadedFile;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use TomatoPHP\FilamentTranslations\Exports\TranslationsExport;
use TomatoPHP\FilamentTranslations\Imports\TranslationsImport;

class ExcelImportExportService
{
    public static function export(): BinaryFileResponse
    {
        $exportClass = config('filament-translations.path_to_custom_excel_export')
            ?? TranslationsExport::class;

        $fileName = date('Y-m-d-H-i-s') . '-translations.xlsx';

        return Excel::download(new $exportClass, $fileName);
    }

    public static function import(UploadedFile | string $file): void
    {
        $importClass = config('filament-translations.path_to_custom_excel_import')
            ?? TranslationsImport::class;

        Excel::import(new $importClass, $file);

        self::sendSuccessNotification();
    }

    private static function sendSuccessNotification(): void
    {
        Notification::make()
            ->title(trans('filament-translations::translation.uploaded'))
            ->success()
            ->send();
    }
}
