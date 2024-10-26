<?php

namespace TomatoPHP\FilamentTranslations\Filament\Resources\TranslationResource\Table\HeaderActions;

use Filament\Tables;
use TomatoPHP\FilamentTranslations\Services\ExcelImportExportService;

class ExportAction extends Action
{
    public static function make(): Tables\Actions\Action
    {
        return Tables\Actions\Action::make('export')
            ->label(trans('filament-translations::translation.export'))
            ->icon('heroicon-o-document-arrow-down')
            ->color('danger')
            ->action(fn () => ExcelImportExportService::export());
    }
}
