<?php

namespace TomatoPHP\FilamentTranslations\Filament\Resources\TranslationResource\Table\Actions;

abstract class Action
{
    abstract public static function make(): \Filament\Tables\Actions\Action;
}
