<?php

namespace TomatoPHP\FilamentTranslations\Filament\Resources\Translations\Tables\HeaderActions;

abstract class Action
{
    abstract public static function make(): \Filament\Actions\Action;
}
