<?php

namespace TomatoPHP\FilamentTranslations\Filament\Resources\TranslationResource\Actions\Components;

use Filament\Actions;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;
use TomatoPHP\FilamentTranslations\Models\Translation;

class ClearAction extends Action
{
    public static function make(): Actions\Action
    {
        return Actions\Action::make('clear')
            ->requiresConfirmation()
            ->icon('heroicon-o-trash')
            ->action(function () {
                Translation::query()->truncate();

                Notification::make()
                    ->title(trans('filament-translations::translation.clear_notifications'))
                    ->success()
                    ->send();
            })
            ->color('danger')
            ->label(trans('filament-translations::translation.clear'));
    }
}
