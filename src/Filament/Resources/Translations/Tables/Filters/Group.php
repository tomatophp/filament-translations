<?php

namespace TomatoPHP\FilamentTranslations\Filament\Resources\Translations\Tables\Filters;

use Filament\Tables\Filters;
use Spatie\TranslationLoader\LanguageLine;

class Group extends Filter
{
    public static function make(): Filters\SelectFilter
    {
        return Filters\SelectFilter::make('group')
            ->label(trans('filament-translations::global.filter_by_group'))
            ->options(fn (): array => LanguageLine::query()->groupBy('group')->pluck('group', 'group')->all());
    }
}
