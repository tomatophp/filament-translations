<?php

namespace TomatoPHP\FilamentTranslations\Filament\Resources\Translations\Tables\Actions;

use Filament\Actions;

class EditAction extends Action
{
    public static function make(): Actions\Action
    {
        return Actions\EditAction::make()
            ->iconButton()
            ->tooltip(__('filament-actions::edit.single.label'));
    }
}
