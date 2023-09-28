<?php

namespace TomatoPHP\FilamentTranslations\Resources\TranslationResource\Pages;

use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Pages\Actions\Action;
use Filament\Pages\Actions\ButtonAction;
use Filament\Resources\Pages\ListRecords;
use TomatoPHP\FilamentTranslations\Services\SaveScan;
use TomatoPHP\FilamentTranslations\Resources\TranslationResource;

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

    /**
     * @return void
     */
    public function scan(): void
    {
        $scan = new SaveScan();
        $scan->save();

        $this->notify('success', 'Translation Has Been Loaded');
    }
}
