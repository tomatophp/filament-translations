<?php

namespace TomatoPHP\FilamentTranslations\Filament\Resources;

use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use TomatoPHP\FilamentTranslations\Filament\Resources\TranslationResource\Form\TranslationForm;
use TomatoPHP\FilamentTranslations\Filament\Resources\TranslationResource\Table\TranslationTable;
use TomatoPHP\FilamentTranslations\Models\Translation;

class TranslationResource extends Resource
{
    protected static ?string $model = Translation::class;

    protected static ?string $slug = 'translations';

    protected static ?string $recordTitleAttribute = 'key';

    protected static bool $isScopedToTenant = false;

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
        return config('filament-translations.languages-switcher-menu.group', trans('filament-translations::translation.group'));
    }

    public static function getNavigationIcon(): string
    {
        return config('filament-translations.languages-switcher-menu.icon', 'heroicon-m-language');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return config('filament-translations.register_navigation', true);
    }

    public function getTitle(): string
    {
        return trans('filament-translations::translation.title.home');
    }

    public static function form(Form $form): Form
    {
        return TranslationForm::make($form);
    }

    public static function table(Table $table): Table
    {
        return TranslationTable::make($table);
    }

    public static function getPages(): array
    {
        if (config('filament-translations.modal')) {
            return [
                'index' => \TomatoPHP\FilamentTranslations\Filament\Resources\TranslationResource\Pages\ManageTranslations::route('/'),
            ];
        } else {
            return [
                'index' => \TomatoPHP\FilamentTranslations\Filament\Resources\TranslationResource\Pages\ListTranslations::route('/'),
                'create' => \TomatoPHP\FilamentTranslations\Filament\Resources\TranslationResource\Pages\CreateTranslation::route('/create'),
                'edit' => \TomatoPHP\FilamentTranslations\Filament\Resources\TranslationResource\Pages\EditTranslation::route('/{record}/edit'),
            ];
        }
    }
}
