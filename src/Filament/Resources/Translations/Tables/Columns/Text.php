<?php

namespace TomatoPHP\FilamentTranslations\Filament\Resources\Translations\Tables\Columns;

use Filament\Tables;

class Text extends Column
{
    public static function make(): Tables\Columns\TextColumn
    {
        return Tables\Columns\TextColumn::make('text')
            ->label(trans('filament-translations::translation.text'))
            ->view('filament-translations::text-column')
            ->searchable();
    }
}
