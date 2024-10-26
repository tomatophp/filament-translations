<?php

namespace TomatoPHP\FilamentTranslations\Filament\Resources\TranslationResource\Table\Filters;

abstract class Filter
{
    abstract public static function make(): \Filament\Tables\Filters\BaseFilter;
}
