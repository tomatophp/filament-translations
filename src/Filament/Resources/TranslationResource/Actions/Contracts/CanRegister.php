<?php

namespace TomatoPHP\FilamentTranslations\Filament\Resources\TranslationResource\Actions\Contracts;

use Filament\Actions\StaticAction;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Support\Concerns\EvaluatesClosures;
use function Filament\Support\get_model_label;

trait CanRegister
{
    use EvaluatesClosures;

    protected static array $actions = [];

    protected static ?Page $page = null;

    public static function make(?Page $page=null): array
    {
        static::$page = $page;

        return (new static)->getActions();
    }

    public function getActions(): array
    {
        return collect($this->getDefaultActions())->merge(static::$actions)->map(function (StaticAction $action){
            if(method_exists($action, 'record') && str($action->getName())->contains(['create', 'edit', 'view'])){
                $action->record(method_exists(static::$page, 'getRecord') ? static::$page->getRecord() : null)
                    ->model(method_exists(static::$page, 'getModel') ? static::$page->getModel() : null)
                    ->modelLabel(method_exists(static::$page, 'getModelLabel') ? get_model_label(static::$page->getModel()) : null)
                    ->form(fn(Form $form) => app(static::$page->getResource())::form($form))
                    ->url(fn() => isset(app(static::$page->getResource())::getPages()[$action->getName()]) ? app(app(static::$page->getResource())::getPages()[$action->getName()]->getPage())->getUrl() : null);
            }
            return $action;
        })->toArray();
    }

    public static function register(StaticAction | array | \Closure $component): void
    {
        if (is_array($component)) {
            foreach ($component as $item) {
                if ($item instanceof StaticAction) {
                    static::$actions[] = $item;
                }
            }
        }
        else if($component instanceof \Closure){
            static::$actions[] = (new static)->evaluate($component);
        }
        else {
            static::$actions[] = $component;
        }
    }
}
