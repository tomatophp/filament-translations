<?php

namespace TomatoPHP\FilamentTranslations\Filament\Resources\Translations\Tables\HeaderActions;

use Filament\Actions;
use Filament\Forms\Components\FileUpload;
use TomatoPHP\FilamentTranslations\Services\ExcelImportExportService;

class ImportAction extends Action
{
    public static function make(): Actions\Action
    {
        return Actions\Action::make('import')
            ->label(trans('filament-translations::translation.import'))
            ->form([
                FileUpload::make('file')
                    ->label(trans('filament-translations::translation.import-file'))
                    ->acceptedFileTypes([
                        'application/csv',
                        'application/vnd.ms-excel',
                        'application/vnd.msexcel',
                        'text/csv',
                        'text/anytext',
                        'text/plain',
                        'text/x-c',
                        'text/comma-separated-values',
                        'inode/x-empty',
                        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    ])
                    ->storeFiles(false),
            ])
            ->icon('heroicon-o-document-arrow-up')
            ->color('success')
            ->action(fn (array $data) => ExcelImportExportService::import($data['file']));
    }
}
