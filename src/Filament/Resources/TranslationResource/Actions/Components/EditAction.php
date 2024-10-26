<?php

namespace TomatoPHP\FilamentTranslations\Filament\Resources\TranslationResource\Actions\Components;

use Filament\Actions;
use Illuminate\Database\Eloquent\Model;
use TomatoPHP\FilamentTranslations\Filament\Resources\TranslationResource\Pages\EditTranslation;

class EditAction extends Action
{
    public static function make(): Actions\Action
    {
        return Actions\EditAction::make();
    }
}
