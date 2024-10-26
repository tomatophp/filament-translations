<?php

namespace TomatoPHP\FilamentTranslations\Tests\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use TomatoPHP\FilamentTranslations\Tests\Models\Translation;

class TranslationFactory extends Factory
{
    protected $model = Translation::class;

    public function definition(): array
    {
        $config = config('filament-translations.locals');
        $text = [];
        foreach ($config as $key => $item) {
            $text[$key] = $this->faker->sentence;
        }

        return [
            'group' => $this->faker->word,
            'key' => $this->faker->word,
            'text' => $text,
            'namespace' => '*',
        ];
    }
}
