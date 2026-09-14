<?php

namespace TomatoPHP\FilamentTranslations\Filament\Resources\Translations\Tables\Filters;

use Filament\Tables\Filters\BaseFilter;

abstract class Filter
{
    abstract public static function make(): BaseFilter;
}
