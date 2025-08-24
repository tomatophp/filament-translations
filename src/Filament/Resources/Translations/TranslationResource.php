<?php

namespace TomatoPHP\FilamentTranslations\Filament\Resources\Translations;

use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use TomatoPHP\FilamentTranslations\Filament\Resources\Translations\Pages\CreateTranslation;
use TomatoPHP\FilamentTranslations\Filament\Resources\Translations\Pages\EditTranslation;
use TomatoPHP\FilamentTranslations\Filament\Resources\Translations\Pages\ListTranslations;
use TomatoPHP\FilamentTranslations\Filament\Resources\Translations\Pages\ManageTranslations;
use TomatoPHP\FilamentTranslations\Filament\Resources\Translations\Schemas\TranslationForm;
use TomatoPHP\FilamentTranslations\Filament\Resources\Translations\Tables\TranslationsTable;
use TomatoPHP\FilamentTranslations\Models\Translation;

class TranslationResource extends Resource
{
    protected static ?string $model = Translation::class;

    protected static ?string $slug = 'translations';

    protected static ?string $recordTitleAttribute = 'key';

    protected static bool $isScopedToTenant = false;

    public static function shouldRegisterNavigation(): bool
    {
        return config('filament-translations.register_navigation', true) && (! config('filament-translations.hide_navigation_when_developer_gate'));
    }

    public static function getNavigationLabel(): string
    {
        return trans('filament-translations::translation.label');
    }

    public static function getLabel(): ?string
    {
        return trans('filament-translations::translation.single');
    }

    public static function getNavigationGroup(): ?string
    {
        return config('filament-translations.navigation_group') ? (str(config('filament-translations.navigation_group'))->contains('.') ? trans(config('filament-translations.navigation_group')) : config('filament-translations.navigation_group')) : trans('filament-translations::translation.group');
    }

    public static function getNavigationIcon(): string
    {
        return config('filament-translations.navigation_icon', 'heroicon-m-language');
    }

    public function getTitle(): string
    {
        return trans('filament-translations::translation.title.home');
    }

    public static function form(Schema $schema): Schema
    {
        return TranslationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TranslationsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        if (config('filament-translations.modal')) {
            return [
                'index' => ManageTranslations::route('/'),
            ];
        } else {
            return [
                'index' => ListTranslations::route('/'),
                'create' => CreateTranslation::route('/create'),
                'edit' => EditTranslation::route('/{record}/edit'),
            ];
        }
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
