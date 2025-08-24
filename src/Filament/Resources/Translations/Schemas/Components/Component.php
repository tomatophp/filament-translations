<?php

namespace TomatoPHP\FilamentTranslations\Filament\Resources\Translations\Schemas\Components;

use Filament\Forms\Components\Field;

abstract class Component
{
    abstract public static function make(): Field;
}
