<?php

namespace TomatoPHP\FilamentTranslations\Filament\Resources\Translations\Tables\Filters;

abstract class Filter
{
    abstract public static function make(): \Filament\Tables\Filters\BaseFilter;
}
