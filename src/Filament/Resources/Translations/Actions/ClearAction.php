<?php

namespace TomatoPHP\FilamentTranslations\Filament\Resources\Translations\Actions;

use Filament\Actions;
use Filament\Notifications\Notification;
use TomatoPHP\FilamentTranslations\Filament\Resources\Translations\TranslationResource;
use TomatoPHP\FilamentTranslations\Models\Translation;

class ClearAction extends Action
{
    public static function make(): Actions\Action
    {
        return Actions\Action::make('clear')
            ->requiresConfirmation()
            ->authorize(fn (): bool => (config('filament-translations.translation_resource') ?: TranslationResource::class)::canDeleteAny())
            ->icon('heroicon-o-trash')
            ->hiddenLabel()
            ->tooltip(trans('filament-translations::translation.clear'))
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
