<?php

namespace TomatoPHP\FilamentTranslations\Resources\TranslationResource\Pages;

use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Actions\ButtonAction;
use Filament\Resources\Pages\ManageRecords;
use TomatoPHP\FilamentTranslations\Services\SaveScan;
use TomatoPHP\FilamentTranslations\Resources\TranslationResource;
use Filament\Notifications\Notification;


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
        ];
    }

    public function scan()
    {
        $scan = new SaveScan();
        $scan->save();

        Notification::make()
            ->title(trans('filament-translations::translation.loaded'))
            ->success()
            ->send();
    }
}
