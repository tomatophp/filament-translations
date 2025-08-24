<?php

namespace TomatoPHP\FilamentTranslations\Facade;

use Illuminate\Support\Facades\Facade;

class FilamentTranslations extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'filament-translations';
    }
}
