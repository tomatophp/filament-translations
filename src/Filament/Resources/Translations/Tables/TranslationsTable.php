<?php

namespace TomatoPHP\FilamentTranslations\Filament\Resources\Translations\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Table;

class TranslationsTable
{
    protected static array $columns = [];

    public static function configure(Table $table): Table
    {
        return $table
            ->deferLoading()
            ->toolbarActions(TranslationBulkActions::make())
            ->recordActions(TranslationActions::make())
            ->filters(TranslationFilters::make())
            ->headerActions(TranslationHeaderActions::make())
            ->deferLoading()
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
        return array_merge(self::getDefaultColumns(), self::$columns);
    }

    public static function register(Column | array $column): void
    {
        if (is_array($column)) {
            foreach ($column as $item) {
                if ($item instanceof Column) {
                    self::$columns[] = $item;
                }
            }
        } else {
            self::$columns[] = $column;
        }
    }
}
