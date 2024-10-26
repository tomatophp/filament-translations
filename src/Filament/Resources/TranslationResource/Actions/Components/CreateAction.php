<?php

namespace TomatoPHP\FilamentTranslations\Filament\Resources\TranslationResource\Actions\Components;

use Filament\Actions;

class CreateAction extends Action
{
    public static function make(): Actions\CreateAction
    {
        return Actions\CreateAction::make();
    }
}
