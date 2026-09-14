<?php

namespace TomatoPHP\FilamentTranslations\Services;

use Filament\Actions\Action;
use Illuminate\Support\Arr;
use TomatoPHP\FilamentTranslations\Filament\Resources\Translations\Pages\ListTranslations;

class FilamentTranslationsServices
{
    /**
     * Page actions keyed by page class and action name, so registering the same action again
     * (the plugin boots on every request under Laravel Octane) replaces it instead of duplicating it.
     *
     * @var array<string, array<string, Action>>
     */
    private array $actions = [];

    public function register(array | Action $action, string $page = ListTranslations::class): void
    {
        foreach (Arr::wrap($action) as $item) {
            if ($item instanceof Action) {
                $this->actions[$page][$item->getName()] = $item;
            }
        }
    }

    public function getActions(string $page = ListTranslations::class): array
    {
        return array_values($this->actions[$page] ?? []);
    }
}
