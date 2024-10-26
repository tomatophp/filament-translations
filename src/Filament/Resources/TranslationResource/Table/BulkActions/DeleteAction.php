<?php

namespace TomatoPHP\FilamentTranslations\Filament\Resources\TranslationResource\Table\BulkActions;

use Filament\Notifications\Notification;
use Filament\Tables;
use Illuminate\Database\Eloquent\Model;

class DeleteAction extends Action
{
    public static function make(): Tables\Actions\DeleteBulkAction
    {
        return Tables\Actions\DeleteBulkAction::make();
    }
}
