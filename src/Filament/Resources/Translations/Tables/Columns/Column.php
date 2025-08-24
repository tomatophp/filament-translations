<?php

namespace TomatoPHP\FilamentTranslations\Filament\Resources\Translations\Tables\Columns;

abstract class Column
{
    abstract public static function make(): \Filament\Tables\Columns\Column;
}
