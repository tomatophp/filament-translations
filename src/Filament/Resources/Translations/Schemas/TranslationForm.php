<?php

namespace TomatoPHP\FilamentTranslations\Filament\Resources\Translations\Schemas;

use Filament\Forms\Components\Field;
use Filament\Schemas\Schema;
use Illuminate\Support\Arr;

class TranslationForm
{
    /**
     * Keyed by field name so a repeated registration (Octane) replaces instead of duplicating.
     *
     * @var array<string, Field>
     */
    protected static array $schema = [];

    public static function configure(Schema $schema): Schema
    {
        return $schema->components(self::getSchema());
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
        return array_values(array_merge(self::getDefaultComponents(), self::$schema));
    }

    public static function register(Field | array $component): void
    {
        foreach (Arr::wrap($component) as $item) {
            if ($item instanceof Field) {
                self::$schema[$item->getName()] = $item;
            }
        }
    }
}
