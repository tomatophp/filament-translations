<?php

namespace TomatoPHP\FilamentTranslations\Resources\TranslationResource\Pages;

use App\Models\User;
use Faker\Core\File;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Actions\ButtonAction;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Http\Request;
use TomatoPHP\FilamentTranslations\Exports\TranslationsExport;
use TomatoPHP\FilamentTranslations\Imports\TranslationsImport;
use TomatoPHP\FilamentTranslations\Services\SaveScan;
use TomatoPHP\FilamentTranslations\Resources\TranslationResource;
use Filament\Notifications\Notification;
use Maatwebsite\Excel\Facades\Excel;


class ManageTranslations extends ManageRecords
{
    protected static string $resource = TranslationResource::class;

    public function getTitle(): string
    {
        return trans('filament-translations::translation.title.home');
    }

    protected function getActions(): array
    {
        return [
            ButtonAction::make('scan')
                ->icon('heroicon-m-magnifying-glass')
                ->action('scan')
                ->label(trans('filament-translations::translation.scan')),
            Action::make('import')
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
                }),
            Action::make('export')
                ->label(trans('filament-translations::translation.export'))
                ->icon('heroicon-o-document-arrow-down')
                ->color('danger')
                ->action('export')
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

    public function scan()
    {
        if(config('filament-translations.use_queue_on_scan')){
            dispatch(new ScanJob());
        }
        else {
            $scan = new SaveScan();
            $scan->save();
        }

        Notification::make()
            ->title(trans('filament-translations::translation.loaded'))
            ->success()
            ->send();
    }
}
