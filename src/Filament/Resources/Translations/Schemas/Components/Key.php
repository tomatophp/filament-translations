<?php

namespace TomatoPHP\FilamentTranslations\Filament\Resources\Translations\Schemas\Components;

use Filament\Forms;
use Filament\Schemas\Components\Utilities\Get;

class Key extends Component
{
    public static function make(): Forms\Components\TextInput
    {
        return Forms\Components\TextInput::make('key')
            ->label(trans('filament-translations::translation.key'))
            ->disabled(fn (Get $get) => $get('id') !== null)
            ->required()
            ->maxLength(255);
    }
}
