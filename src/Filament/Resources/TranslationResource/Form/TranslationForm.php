<?php

namespace TomatoPHP\FilamentTranslations\Filament\Resources\TranslationResource\Form;

use Filament\Forms\Components\Field;
use Filament\Forms\Form;

class TranslationForm
{
    protected static array $schema = [];

    public static function make(Form $form): Form
    {
        return $form->schema(self::getSchema());
    }

    public static function getDefaultComponents(): array
    {
        return [
            Components\Group::make(),
            Components\Key::make(),
            Components\Text::make(),
        ];
    }

    private static function getSchema(): array
    {
        return array_merge(self::getDefaultComponents(), self::$schema);
    }

    public static function register(Field | array $component): void
    {
        if (is_array($component)) {
            foreach ($component as $item) {
                if ($item instanceof Field) {
                    self::$schema[] = $item;
                }
            }

        } else {
            self::$schema[] = $component;
        }
    }
}
