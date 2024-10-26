<?php

namespace TomatoPHP\FilamentTranslations\Filament\Resources\TranslationResource\Table\HeaderActions;

abstract class Action
{
    abstract public static function make(): \Filament\Tables\Actions\Action;
}
