<?php

namespace TomatoPHP\FilamentTranslations\Resources;

use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
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
        $schema = [];

        $schema = [
            Forms\Components\TextInput::make('group')
                ->label(trans('filament-translations::translation.group'))
                ->required()
                ->disabled(fn(Forms\Get $get) => $get('id') !== null)
                ->maxLength(255),
            Forms\Components\TextInput::make('key')
                ->label(trans('filament-translations::translation.key'))
                ->disabled(fn(Forms\Get $get) => $get('id') !== null)
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
        $actions = [];
        if (config('filament-translations.import_enabled')) {
            $actions[] = Tables\Actions\Action::make('import')
                ->label(trans('filament-translations::translation.import'))
                ->form([
                    FileUpload::make('file')
                        ->label(trans('filament-translations::translation.import-file'))
                        ->acceptedFileTypes([
                            "application/csv",
                            "application/vnd.ms-excel",
                            "application/vnd.msexcel",
                            "text/csv",
                            "text/anytext",
                            "text/plain",
                            "text/x-c",
                            "text/comma-separated-values",
                            "inode/x-empty",
                            "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                        ])
                        ->storeFiles(false)
                ])
                ->icon('heroicon-o-document-arrow-up')
                ->color('success')
                ->action(function (array $data): void {
                    $this->import($data);
                });
        }

        if (config('filament-translations.export_enabled')) {
            $actions[] = Tables\Actions\Action::make('export')
                ->label(trans('filament-translations::translation.export'))
                ->icon('heroicon-o-document-arrow-down')
                ->color('danger')
                ->action('export');
        }
        $table
            ->headerActions($actions)
            ->columns([
                Tables\Columns\TextColumn::make('key')
                    ->label(trans('filament-translations::translation.key'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('text')
                    ->label(trans('filament-translations::translation.text'))
                    ->view('filament-translations::text-column')
                    ->searchable(),
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
