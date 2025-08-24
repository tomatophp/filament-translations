<?php

namespace TomatoPHP\FilamentTranslations\Filament\Resources\Translations\Tables\Actions;

use Filament\Actions;

class DeleteAction extends Action
{
    public static function make(): Actions\Action
    {
        return Actions\DeleteAction::make()
            ->iconButton()
            ->tooltip(__('filament-actions::delete.single.label'));
    }
}
