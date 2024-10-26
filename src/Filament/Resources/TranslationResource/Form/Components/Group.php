<?php

namespace TomatoPHP\FilamentTranslations\Filament\Resources\TranslationResource\Form\Components;

use Filament\Forms;

class Group extends Component
{
    public static function make(): Forms\Components\TextInput
    {
        return Forms\Components\TextInput::make('group')
            ->label(trans('filament-translations::translation.group'))
            ->required()
            ->disabled(fn (Forms\Get $get) => $get('id') !== null)
            ->maxLength(255);
    }
}
