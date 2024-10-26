<?php

namespace TomatoPHP\FilamentTranslations\Filament\Resources\TranslationResource\Actions\Components;

use Illuminate\Database\Eloquent\Model;

abstract class Action
{
    abstract public static function make(): \Filament\Actions\Action;
}
