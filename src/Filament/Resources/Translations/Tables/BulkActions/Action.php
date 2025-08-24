<?php

namespace TomatoPHP\FilamentTranslations\Filament\Resources\Translations\Tables\BulkActions;

use Filament\Actions\BulkAction;

abstract class Action
{
    abstract public static function make(): BulkAction;
}
