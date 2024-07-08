<?php

namespace TomatoPHP\FilamentTranslations\Resources\TranslationResource\Pages;

use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\Select;
use Illuminate\Support\Str;
use OpenAI\Laravel\Facades\OpenAI;
use Stichoza\GoogleTranslate\GoogleTranslate;
use TomatoPHP\FilamentTranslations\Jobs\ScanWithGoogleTranslate;
use TomatoPHP\FilamentTranslations\Jobs\ScanWithGPT;
use TomatoPHP\FilamentTranslations\Models\Translation;
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

        if(filament('filament-translations')->allowGPTScan && class_exists(OpenAI::class)){
            $actions[] = Action::make('gpt')
                ->requiresConfirmation()
                ->icon('heroicon-o-link')
                ->form([
                    Select::make('language')
                        ->searchable()
                        ->options(collect(config('filament-translations.locals'))->pluck('label', 'label')->toArray())
                        ->label(trans('filament-translations::translation.gpt_scan_language'))
                        ->required()
                ])
                ->action(function (array $data){
                    dispatch(new ScanWithGPT($data['language'], auth()->user()->id,get_class(auth()->user())));

                    Notification::make()
                        ->title(trans('filament-translations::translation.gpt_scan_notification_start'))
                        ->success()
                        ->send();
                })
                ->color('warning')
                ->label(trans('filament-translations::translation.gpt_scan'));
        }

	    if (filament('filament-translations')->allowGoogleTranslateScan && class_exists(GoogleTranslate::class)) {
		    $actions[] = Action::make('google')
			    ->requiresConfirmation()
			    ->icon('heroicon-o-language')
			    ->form([
				    Select::make('language')
					    ->searchable()
					    ->options(
						    collect(config('filament-translations.locals'))->mapWithKeys(function ($item, $key) {
							    return [$key => $item['label']];
						    })->toArray()
					    )
					    ->label(trans('filament-translations::translation.language'))
					    ->required()
			    ])
			    ->action(function (array $data) {
				    dispatch(
					    new ScanWithGoogleTranslate(auth()->user(), $data['language'])
				    );

				    Notification::make()
					    ->title(trans('filament-translations::translation.google_scan_notifications_start'))
					    ->success()
					    ->send();
			    })
			    ->color('warning')
			    ->label(trans('filament-translations::translation.google_scan'));
	    }

        if(filament('filament-translations')->allowClearTranslations){
            $actions[] = Action::make('clear')
                ->requiresConfirmation()
                ->icon('heroicon-o-trash')
                ->action(function (){
                    Translation::query()->truncate();

                    Notification::make()
                        ->title(trans('filament-translations::translation.clear_notifications'))
                        ->success()
                        ->send();
                })
                ->color('danger')
                ->label(trans('filament-translations::translation.clear'));
        }

        if(filament('filament-translations')->allowCreate){
            $actions[] = CreateAction::make();
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
