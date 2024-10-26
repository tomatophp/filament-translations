<?php

namespace TomatoPHP\FilamentTranslations\Filament\Resources\TranslationResource\Table\Columns;

abstract class Column
{
    abstract public static function make(): \Filament\Tables\Columns\Column;
}
