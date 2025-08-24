<?php

namespace TomatoPHP\FilamentTranslations\Filament\Resources\Translations\Tables\Columns;

use Filament\Tables;

class UpdatedAt extends Column
{
    public static function make(): Tables\Columns\TextColumn
    {
        return Tables\Columns\TextColumn::make('updated_at')
            ->dateTime()
            ->description(fn ($record) => $record->updated_at->diffForHumans())
            ->toggleable(isToggledHiddenByDefault: true)
            ->sortable();
    }
}
