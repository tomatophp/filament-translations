<?php

namespace TomatoPHP\FilamentTranslations\Filament\Resources\TranslationResource\Form\Components;

use Filament\Forms;

class Key extends Component
{
    public static function make(): Forms\Components\TextInput
    {
        return Forms\Components\TextInput::make('key')
            ->label(trans('filament-translations::translation.key'))
            ->disabled(fn (Forms\Get $get) => $get('id') !== null)
            ->required()
            ->maxLength(255);
    }
}
