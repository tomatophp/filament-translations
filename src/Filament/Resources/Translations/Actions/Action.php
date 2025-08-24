<?php

namespace TomatoPHP\FilamentTranslations\Filament\Resources\Translations\Actions;

abstract class Action
{
    abstract public static function make(): \Filament\Actions\Action;
}
