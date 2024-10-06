<?php

namespace TomatoPHP\FilamentTranslations\Resources\TranslationResource\Pages;

use TomatoPHP\FilamentTranslations\Resources\TranslationResource;
use Filament\Resources\Pages\EditRecord;

class EditTranslation extends EditRecord
{
    protected static string $resource;

    public static function setResourceClass(string $resourceClass): void
    {
        static::$resource = $resourceClass;
    }

    public function getTitle(): string
    {
        return trans('filament-translations::translation.title.edit');
    }
}
