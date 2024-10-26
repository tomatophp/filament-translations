<?php

namespace TomatoPHP\FilamentTranslations\Filament\Resources\TranslationResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\ViewRecord;
use TomatoPHP\FilamentTranslations\Filament\Resources\TranslationResource;

class ViewTranslations extends ViewRecord
{
    protected static string $resource = TranslationResource::class;


    protected function getHeaderActions(): array
    {
        return TranslationResource\Actions\ViewPageActions::make($this);
    }
}
