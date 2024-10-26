<?php

namespace TomatoPHP\FilamentTranslations\Filament\Resources\TranslationResource\Actions;

final class EditPageActions
{
    use Contracts\CanRegister;

    public function getDefaultActions(): array
    {
        return [
            Components\ViewAction::make(),
            Components\DeleteAction::make(),
        ];
    }
}
