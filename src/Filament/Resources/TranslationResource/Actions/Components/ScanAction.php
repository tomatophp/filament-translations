<?php

namespace TomatoPHP\FilamentTranslations\Filament\Resources\TranslationResource\Actions\Components;

use Filament\Actions;
use Filament\Notifications\Notification;
use TomatoPHP\FilamentTranslations\Jobs\ScanJob;
use TomatoPHP\FilamentTranslations\Services\SaveScan;

use function Laravel\Prompts\spin;

class ScanAction extends Action
{
    public static function make(): Actions\Action
    {
        return Actions\Action::make('scan')
            ->requiresConfirmation()
            ->icon('heroicon-m-magnifying-glass')
            ->hiddenLabel()
            ->tooltip(trans('filament-translations::translation.scan'))
            ->action(function () {
                if (config('filament-translations.use_queue_on_scan')) {
                    dispatch(new ScanJob);
                } elseif (config('filament-translations.path_to_custom_import_command')) {
                    spin(
                        function () {
                            $command = config('filament-translations.path_to_custom_import_command');
                            $command = new $command;
                            $command->handle();
                        },
                        'Fetching keys...'
                    );
                } else {
                    $scan = new SaveScan;
                    $scan->save();
                }

                Notification::make()
                    ->title(trans('filament-translations::translation.loaded'))
                    ->success()
                    ->send();
            })
            ->label(trans('filament-translations::translation.scan'));
    }
}
