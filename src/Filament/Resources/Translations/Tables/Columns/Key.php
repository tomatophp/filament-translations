<?php

namespace TomatoPHP\FilamentTranslations\Filament\Resources\Translations\Tables\Columns;

use Filament\Tables;

class Key extends Column
{
    public static function make(): Tables\Columns\TextColumn
    {
        return Tables\Columns\TextColumn::make('key')
            ->label(trans('filament-translations::translation.key'))
            ->searchable()
            ->limit(30)
            ->tooltip(fn ($record) => $record->key)
            ->sortable();
    }
}
