<?php

namespace TomatoPHP\FilamentTranslations\Filament\Resources\TranslationResource\InfoList;

use Filament\Infolists\Components\Entry;
use Filament\Infolists\Infolist;

class TranslationInfoList
{
    protected static array $schema = [];

    public static function make(Infolist $infolist): Infolist
    {
        return $infolist->schema(self::getSchema());
    }

    public static function getDefaultComponents(): array
    {
        return [
            //
        ];
    }

    private static function getSchema(): array
    {
        return array_merge(self::getDefaultComponents(), self::$schema);
    }

    public static function register(Entry | array $component): void
    {
        if (is_array($component)) {
            foreach ($component as $item) {
                if ($item instanceof Entry) {
                    self::$schema[] = $item;
                }
            }

        } else {
            self::$schema[] = $component;
        }
    }
}
