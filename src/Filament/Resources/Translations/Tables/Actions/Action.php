<?php

namespace TomatoPHP\FilamentTranslations\Filament\Resources\Translations\Tables\Actions;

abstract class Action
{
    abstract public static function make(): \Filament\Actions\Action;
}
