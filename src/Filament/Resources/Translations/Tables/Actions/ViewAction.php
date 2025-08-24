<?php

namespace TomatoPHP\FilamentTranslations\Filament\Resources\Translations\Tables\Actions;

use Filament\Actions;

class ViewAction extends Action
{
    public static function make(): Actions\Action
    {
        return Actions\ViewAction::make()
            ->iconButton()
            ->tooltip(__('filament-actions::view.single.label'));
    }
}
