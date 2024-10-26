<?php

namespace TomatoPHP\FilamentTranslations\Filament\Resources\TranslationResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use TomatoPHP\FilamentTranslations\Filament\Resources\TranslationResource;

class CreateTranslation extends CreateRecord
{
    protected static string $resource = TranslationResource::class;

    public function getTitle(): string
    {
        return trans('filament-translations::translation.title.create');
    }

    protected function getHeaderActions(): array
    {
        return TranslationResource\Actions\CreatePageActions::make($this);
    }
}
