<?php

namespace TomatoPHP\FilamentTranslations\Services;

use Filament\Actions\Action;
use TomatoPHP\FilamentTranslations\Filament\Resources\Translations\Pages\ListTranslations;

class FilamentTranslationsServices
{
    private array $actions = [];

    public function register(array | Action $action, string $page = ListTranslations::class): void
    {
        if (is_array($action)) {
            foreach ($action as $item) {
                if ($item instanceof Action) {
                    $this->actions[$page][] = $item;
                }
            }
        } else {
            $this->actions[$page][] = $action;
        }

    }

    public function getActions(string $page = ListTranslations::class): array
    {
        return $this->actions[$page] ?? [];
    }
}
