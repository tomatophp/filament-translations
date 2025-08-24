<?php

namespace TomatoPHP\FilamentTranslations\Filament\Resources\Translations\Schemas\Components;

use Filament\Forms;
use Filament\Schemas\Components\Utilities\Get;

class Group extends Component
{
    public static function make(): Forms\Components\TextInput
    {
        return Forms\Components\TextInput::make('group')
            ->label(trans('filament-translations::translation.group'))
            ->required()
            ->disabled(fn (Get $get) => $get('id') !== null)
            ->maxLength(255);
    }
}
