<?php

namespace TomatoPHP\FilamentTranslations\Filament\Resources\TranslationResource\Pages;

use Filament\Resources\Pages\ListRecords;
use TomatoPHP\FilamentTranslations\Filament\Resources\TranslationResource;

class ListTranslations extends ListRecords
{
    protected static string $resource = TranslationResource::class;

    public function getTitle(): string
    {
        return trans('filament-translations::translation.title.list');
    }

    protected function getHeaderActions(): array
    {
        return TranslationResource\Actions\ManagePageActions::make($this);
    }
}
