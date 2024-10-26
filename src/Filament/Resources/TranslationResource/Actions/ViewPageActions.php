<?php

namespace TomatoPHP\FilamentTranslations\Filament\Resources\TranslationResource\Actions;

class ViewPageActions
{
    use Contracts\CanRegister;

    public function getDefaultActions(): array
    {
        return [
            Components\EditAction::make(),
            Components\DeleteAction::make()
        ];
    }
}
