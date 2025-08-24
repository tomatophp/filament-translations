<?php

namespace TomatoPHP\FilamentTranslations\Filament\Resources\Translations\Tables\Filters;

use Filament\Tables\Filters;
use Illuminate\Database\Eloquent\Builder;

class Text extends Filter
{
    public static function make(): Filters\Filter
    {
        return Filters\Filter::make('text')
            ->label(trans('filament-translations::global.filter_by_null_text'))
            ->query(fn (Builder $query): Builder => $query->whereJsonContains('text', []));
    }
}
