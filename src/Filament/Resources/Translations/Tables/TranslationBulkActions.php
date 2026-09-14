<?php

namespace TomatoPHP\FilamentTranslations\Filament\Resources\Translations\Tables;

use Filament\Actions\BulkAction;
use Illuminate\Support\Arr;

class TranslationBulkActions
{
    /**
     * Keyed by action name so a repeated registration (Octane) replaces instead of duplicating.
     *
     * @var array<string, BulkAction>
     */
    protected static $actions = [];

    public static function make(): array
    {
        return self::getActions();
    }

    private static function getDefaultActions(): array
    {
        return [
            BulkActions\DeleteAction::make(),
        ];
    }

    private static function getActions(): array
    {
        return array_values(array_merge(self::getDefaultActions(), self::$actions));
    }

    public static function register(BulkAction | array $action): void
    {
        foreach (Arr::wrap($action) as $item) {
            if ($item instanceof BulkAction) {
                self::$actions[$item->getName()] = $item;
            }
        }
    }
}
