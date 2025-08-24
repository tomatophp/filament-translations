<?php

namespace TomatoPHP\FilamentTranslations\Filament\Resources\Translations\Tables;

class TranslationActions
{
    /**
     * @var array
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
        return array_merge(self::getDefaultActions(), self::$actions);
    }

    public static function register(\Filament\Actions\Action | array $action): void
    {
        if (is_array($action)) {
            foreach ($action as $item) {
                if ($item instanceof \Filament\Actions\Action) {
                    self::$actions[] = $item;
                }
            }
        } else {
            self::$actions[] = $action;
        }
    }
}
