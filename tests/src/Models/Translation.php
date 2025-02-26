<?php

namespace TomatoPHP\FilamentTranslations\Tests\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\TranslationLoader\LanguageLine;
use TomatoPHP\FilamentTranslations\Tests\Database\Factories\TranslationFactory;

class Translation extends LanguageLine
{
    use HasFactory;
    use SoftDeletes;

    /** @var array */
    public $guarded = ['id'];

    /** @var array */
    protected $casts = ['text' => 'array'];

    protected $table = 'language_lines';

    protected $fillable = [
        'group',
        'key',
        'text',
        'namespace',
    ];

    public static function getTranslatableLocales(): array
    {
        return config('filament-translations.locals');
    }

    public function getTranslation(string $locale, ?string $group = null): string
    {
        if ($group === '*' && ! isset($this->text[$locale])) {
            $fallback = config('app.fallback_locale');

            return $this->text[$fallback] ?? $this->key;
        }

        return $this->text[$locale] ?? '';
    }

    public function setTranslation(string $locale, string $value): static
    {
        $this->text = array_merge($this->text ?? [], [$locale => $value]);

        return $this;
    }

    protected function getTranslatedLocales(): array
    {
        return array_keys($this->text);
    }

    protected static function newFactory(): TranslationFactory
    {
        return TranslationFactory::new();
    }
}
