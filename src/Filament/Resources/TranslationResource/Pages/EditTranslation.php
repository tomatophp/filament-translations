<?php

namespace TomatoPHP\FilamentTranslations\Filament\Resources\TranslationResource\Pages;

use Filament\Resources\Pages\EditRecord;
use TomatoPHP\FilamentTranslations\Filament\Resources\TranslationResource;

class EditTranslation extends EditRecord
{
    protected static string $resource = TranslationResource::class;

    public function getTitle(): string
    {
        return trans('filament-translations::translation.title.edit');
    }

    protected function getHeaderActions(): array
    {
        return TranslationResource\Actions\EditPageActions::make($this);
    }
}
