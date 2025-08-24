<?php

namespace TomatoPHP\FilamentTranslations\Filament\Resources\Translations\Schemas\Components;

class Text extends Component
{
    public static function make(): \TomatoPHP\FilamentTranslationComponent\Components\Translation
    {
        return \TomatoPHP\FilamentTranslationComponent\Components\Translation::make('text')
            ->label(trans('filament-translations::translation.text'))
            ->textarea()
            ->nullable()
            ->columnSpanFull();
    }
}
