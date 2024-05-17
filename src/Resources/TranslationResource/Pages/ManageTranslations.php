<?php

namespace TomatoPHP\FilamentTranslations\Resources\TranslationResource\Pages;

use Filament\Actions\Action;
use function Laravel\Prompts\spin;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Notifications\Notification;
use Filament\Pages\Actions\ButtonAction;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Pages\ManageRecords;
use TomatoPHP\FilamentTranslations\Jobs\ScanJob;
use TomatoPHP\FilamentTranslations\Services\SaveScan;
use TomatoPHP\FilamentTranslations\Exports\TranslationsExport;
use TomatoPHP\FilamentTranslations\Imports\TranslationsImport;
use TomatoPHP\FilamentTranslations\Resources\TranslationResource;


class ManageTranslations extends ManageRecords
{
    protected static string $resource = TranslationResource::class;

    public function getTitle(): string
    {
        return trans('filament-translations::translation.title.home');
    }

    protected function getActions(): array
    {
        $actions = [];

        if (config('filament-translations.scan_enabled')) {
            $actions[] = ButtonAction::make('scan')
                ->icon('heroicon-m-magnifying-glass')
                ->action('scan')
                ->label(trans('filament-translations::translation.scan'));
        }

        if (config('filament-translations.import_enabled')) {
            $actions[] = Action::make('import')
                ->label(trans('filament-translations::translation.import'))
                ->form([
                    FileUpload::make('file')
                        ->label(trans('filament-translations::translation.import-file'))
                        ->acceptedFileTypes([
                            "application/csv",
                            "application/vnd.ms-excel",
                            "application/vnd.msexcel",
                            "text/csv",
                            "text/anytext",
                            "text/plain",
                            "text/x-c",
                            "text/comma-separated-values",
                            "inode/x-empty",
                            "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                        ])
                        ->storeFiles(false)
                ])
                ->icon('heroicon-o-document-arrow-up')
                ->color('success')
                ->action(function (array $data): void {
                    $this->import($data);
                });
        }

        if (config('filament-translations.export_enabled')) {
            $actions[] = Action::make('export')
                ->label(trans('filament-translations::translation.export'))
                ->icon('heroicon-o-document-arrow-down')
                ->color('danger')
                ->action('export');
        }

        return $actions;
    }

    public function export()
    {
        return Excel::download(new TranslationsExport(), date('d-m-Y-H-i-s') . '-translations.xlsx');
    }

    public function import(array $data)
    {
        $file = $data['file'];
        Excel::import(new TranslationsImport, $file);

        Notification::make()
            ->title(trans('filament-translations::translation.uploaded'))
            ->success()
            ->send();
    }

    public function scan(): void
    {
        if (config('filament-translations.use_queue_on_scan')) {
            $this->dispatchScanJob();
        } elseif (config('filament-translations.path_to_custom_import_command')) {
            $this->runCustomImportCommand();
        } else {
            $this->saveScan();
        }
    
        $this->sendNotification();
    }
    
    protected function dispatchScanJob(): void
    {
        dispatch(new ScanJob());
    }
    
    protected function runCustomImportCommand(): void
    {
        spin(
            function () {
                $command = config('filament-translations.path_to_custom_import_command');
                $command = new $command();
                $command->handle();
            },
            'Fetching keys...'
        );
    }
    
    protected function saveScan(): void
    {
        $scan = new SaveScan();
        $scan->save();
    }
    
    protected function sendNotification(): void
    {
        Notification::make()
            ->title(trans('filament-translations::translation.loaded'))
            ->success()
            ->send();
    }
}
