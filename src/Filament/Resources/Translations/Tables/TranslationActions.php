<?php

namespace TomatoPHP\FilamentTranslations\Filament\Resources\Translations\Tables;

use Filament\Actions\Action;
use Illuminate\Support\Arr;

class TranslationActions
{
    /**
     * Keyed by action name so a repeated registration (Octane) replaces instead of duplicating.
     *
     * @var array<string, Action>
     */
    protected static $actions = [];

    public static function make(): array
    {
        return self::getActions();
    }

    private static function getDefaultActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    private static function getActions(): array
    {
        return array_values(array_merge(self::getDefaultActions(), self::$actions));
    }

    public static function register(Action | array $action): void
    {
        foreach (Arr::wrap($action) as $item) {
            if ($item instanceof Action) {
                self::$actions[$item->getName()] = $item;
            }
        }
    }
}
