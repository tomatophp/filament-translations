<?php

namespace TomatoPHP\FilamentTranslations\Filament\Resources\TranslationResource\Table\Columns;

use Filament\Tables;

class CreatedAt extends Column
{
    public static function make(): Tables\Columns\TextColumn
    {
        return Tables\Columns\TextColumn::make('created_at')
            ->dateTime()
            ->description(fn ($record) => $record->created_at->diffForHumans())
            ->toggleable(isToggledHiddenByDefault: true)
            ->sortable();
    }
}
