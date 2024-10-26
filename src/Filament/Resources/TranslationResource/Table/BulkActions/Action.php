<?php

namespace TomatoPHP\FilamentTranslations\Filament\Resources\TranslationResource\Table\BulkActions;

use Filament\Tables\Actions\BulkAction;

abstract class Action
{
    abstract public static function make(): BulkAction;
}
