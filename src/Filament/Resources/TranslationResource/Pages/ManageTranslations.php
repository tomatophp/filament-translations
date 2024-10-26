<?php

namespace TomatoPHP\FilamentTranslations\Filament\Resources\TranslationResource\Pages;

use Filament\Resources\Pages\ManageRecords;
use TomatoPHP\FilamentTranslations\Filament\Resources\TranslationResource;

class ManageTranslations extends ManageRecords
{
    protected static string $resource = TranslationResource::class;

    public function getTitle(): string
    {
        return trans('filament-translations::translation.title.home');
    }

    protected function getActions(): array
    {
        return TranslationResource\Actions\ManagePageActions::make($this);
    }
}
