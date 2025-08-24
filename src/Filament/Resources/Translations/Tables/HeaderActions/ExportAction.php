<?php

namespace TomatoPHP\FilamentTranslations\Filament\Resources\Translations\Tables\HeaderActions;

use Filament\Actions;
use TomatoPHP\FilamentTranslations\Services\ExcelImportExportService;

class ExportAction extends Action
{
    public static function make(): Actions\Action
    {
        return Actions\Action::make('export')
            ->label(trans('filament-translations::translation.export'))
            ->icon('heroicon-o-document-arrow-down')
            ->color('danger')
            ->action(fn () => ExcelImportExportService::export());
    }
}
