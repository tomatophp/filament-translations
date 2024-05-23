<?php

namespace TomatoPHP\FilamentTranslations\Resources\TranslationResource\Pages;

use Filament\Notifications\Notification;
use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Maatwebsite\Excel\Facades\Excel;
use TomatoPHP\FilamentTranslations\Exports\TranslationsExport;
use TomatoPHP\FilamentTranslations\Imports\TranslationsImport;
use TomatoPHP\FilamentTranslations\Jobs\ScanJob;
use TomatoPHP\FilamentTranslations\Services\SaveScan;
use TomatoPHP\FilamentTranslations\Resources\TranslationResource;
use function Laravel\Prompts\spin;

class ListTranslations extends ListRecords
{

    protected static string $resource = TranslationResource::class;


    public function getTitle(): string
    {
        return trans('filament-translations::translation.title.list');
    }

    protected function getActions(): array
    {
        $options = [];
        foreach (config('filament-translations.locals') as $key=>$item){
            $options[$key] = $item['label'];
        }
        return [
            Action::make('scan')
                ->icon('heroicon-m-magnifying-glass')
                ->action('scan')
                ->label(trans('filament-translations::translation.scan'))
        ];
    }

    public function export()
    {
        return Excel::download(new TranslationsExport(), date('d-m-Y-H-i-s') .'-translations.xlsx');
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

    /**
     * @return void
     */
    public function scan(): void
    {
        if (config('filament-translations.use_queue_on_scan')) {
            $this->dispatchScanJob();
        } elseif (config('filament-translations.path_to_custom_import_command')) {
            $this->runCustomImportCommand();
        } else {
            $this->saveScan();
        }
    
        $this->notify('success', 'Translation Has Been Loaded');
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
}
