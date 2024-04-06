<?php

namespace TomatoPHP\FilamentTranslations\Resources;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Spatie\TranslationLoader\LanguageLine;
use TomatoPHP\FilamentTranslations\Models\Translation;
use TomatoPHP\FilamentTranslations\Resources\TranslationResource\Pages;

class TranslationResource extends Resource
{
    protected static ?string $model = Translation::class;

    protected static ?string $slug = 'translations';

    protected static ?string $recordTitleAttribute = 'key';

    public static function getNavigationLabel(): string
    {
        return trans('filament-translations::translation.label');
    }

    public static function getNavigationGroup(): ?string
    {
        return config('filament-translations.languages-switcher-menu.group', 'Translations');
    }

    public static function getNavigationIcon(): string
    {
        return config('filament-translations.languages-switcher-menu.icon', 'heroicon-m-language');
    }

    public function getTitle(): string
    {
        return trans('filament-translations::translation.title.home');
    }

    public static function form(Form $form): Form
    {
        $schema = [];

        $schema = [
            Forms\Components\TextInput::make('group')
                ->label(trans('filament-translations::translation.group'))
                ->required()
                ->disabled()
                ->maxLength(255),
            Forms\Components\TextInput::make('namespace')
                ->label(trans('filament-translations::translation.namespace'))
                ->required()
                ->disabled()
                ->default('*')
                ->maxLength(255),
            Forms\Components\TextInput::make('key')
                ->label(trans('filament-translations::translation.key'))
                ->columnSpan(2)
                ->disabled()
                ->required()
                ->maxLength(255)

        ];

        foreach (config('filament-translations.locals') as $key => $lang) {
            $schema[] = Forms\Components\Textarea::make('text.'.$key)
                ->label(trans('filament-translations::translation.lang.'.$key));
        }

        return $form->schema($schema);
    }

    public static function table(Table $table): Table
    {
        $table
            ->columns([
                Tables\Columns\TextColumn::make('group')
                    ->label(trans('filament-translations::translation.group'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('key')
                    ->label(trans('filament-translations::translation.key'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('text')
                    ->label(trans('filament-translations::translation.text'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(trans('filament-translations::global.created_at'))
                    ->dateTime('M j, Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(trans('filament-translations::global.updated_at'))
                    ->dateTime('M j, Y')
                    ->sortable(),
            ])
            ->filters([
               Tables\Filters\SelectFilter::make('group')
                   ->label(trans('filament-translations::global.filter_by_group'))
                   ->options(fn (): array => LanguageLine::query()->groupBy('group')->pluck('group','group')->all()),
                Tables\Filters\Filter::make('text')
                    ->label(trans('filament-translations::global.filter_by_null_text'))
                    ->query(fn (Builder $query): Builder => $query->whereJsonContains('text',  []))
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);

        if (!config('filament-translations.modal')) {
            $table->actions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make()
                ]),
            ]);
        }
        else {
            $table->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
        }


        return $table;
    }

    public static function getPages(): array
    {
        if (config('filament-translations.modal')) {
            return [
                'index' => Pages\ManageTranslations::route('/'),
            ];
        } else {
            return [
                'index' => Pages\ListTranslations::route('/'),
                'create' => Pages\CreateTranslation::route('/create'),
                'edit' => Pages\EditTranslation::route('/{record}/edit'),
            ];
        }
    }
}
