<?php

namespace TomatoPHP\FilamentTranslations\Filament\Resources\TranslationResource\Table;

use Filament\Tables\Columns\Column;
use Filament\Tables\Table;

class TranslationTable
{
    protected static array $columns = [];

    public static function make(Table $table): Table
    {
        return $table
            ->deferLoading()
            ->bulkActions(TranslationBulkActions::make())
            ->actions(TranslationActions::make())
            ->filters(TranslationFilters::make())
            ->headerActions(TranslationHeaderActions::make())
            ->deferLoading()
            ->defaultSort('key')
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
