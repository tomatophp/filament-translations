<?php

namespace TomatoPHP\FilamentTranslations\Filament\Resources\Translations\Tables;

use Filament\Tables\Filters\BaseFilter;
use Illuminate\Support\Arr;

class TranslationFilters
{
    /**
     * Keyed by filter name so a repeated registration (Octane) replaces instead of duplicating.
     *
     * @var array<string, BaseFilter>
     */
    protected static $filters = [];

    public static function make(): array
    {
        return self::getFilters();
    }

    private static function getDefaultFilters(): array
    {
        return [
            Filters\Group::make(),
            Filters\Text::make(),
        ];
    }

    private static function getFilters(): array
    {
        return array_values(array_merge(self::getDefaultFilters(), self::$filters));
    }

    public static function register(BaseFilter | array $filter): void
    {
        foreach (Arr::wrap($filter) as $item) {
            if ($item instanceof BaseFilter) {
                self::$filters[$item->getName()] = $item;
            }
        }
    }
}
