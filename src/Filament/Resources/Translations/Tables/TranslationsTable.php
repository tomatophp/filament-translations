<?php

namespace TomatoPHP\FilamentTranslations\Filament\Resources\Translations\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Table;
use Illuminate\Support\Arr;

class TranslationsTable
{
    /**
     * Keyed by column name so a repeated registration (Octane) replaces instead of duplicating.
     *
     * @var array<string, Column>
     */
    protected static array $columns = [];

    public static function configure(Table $table): Table
    {
        return $table
            ->deferLoading()
            ->toolbarActions(TranslationBulkActions::make())
            ->recordActions(TranslationActions::make())
            ->filters(TranslationFilters::make())
            ->headerActions(TranslationHeaderActions::make())
            ->defaultSort('key')
            ->striped()
            ->columns(self::getColumns());
    }

    public static function getDefaultColumns(): array
    {
        return [
            Columns\Key::make(),
            Columns\Text::make(),
            Columns\CreatedAt::make(),
            Columns\UpdatedAt::make(),
        ];
    }

    private static function getColumns(): array
    {
        return array_values(array_merge(self::getDefaultColumns(), self::$columns));
    }

    public static function register(Column | array $column): void
    {
        foreach (Arr::wrap($column) as $item) {
            if ($item instanceof Column) {
                self::$columns[$item->getName()] = $item;
            }
        }
    }
}
