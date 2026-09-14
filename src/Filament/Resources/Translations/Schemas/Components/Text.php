<?php

namespace TomatoPHP\FilamentTranslations\Filament\Resources\Translations\Schemas\Components;

use TomatoPHP\FilamentTranslationComponent\Components\Translation;

class Text extends Component
{
    public static function make(): Translation
    {
        return Translation::make('text')
            ->label(trans('filament-translations::translation.text'))
            ->textarea()
            ->nullable()
            ->columnSpanFull();
    }
}
