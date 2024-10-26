<?php

namespace TomatoPHP\FilamentTranslations\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Validators\Failure;
use Spatie\TranslationLoader\LanguageLine;

class CustomTranslationImport implements SkipsOnFailure, ToCollection, WithHeadingRow
{
    public function collection(Collection $collection): void
    {
        $locales = config('filament-translations.locals');

        foreach ($collection as $languageLine) {
            $translation = LanguageLine::firstOrNew(['id' => $languageLine['id']]);

            $mergeTranslation = [];
            foreach ($locales as $langKey => $lang) {
                $mergeTranslation[$langKey] = $languageLine[$langKey];
            }
            $translation->text = $mergeTranslation;
            $translation->save();
        }
    }

    /**
     * @param  Failure[]  $failures
     */
    public function onFailure(Failure ...$failures)
    {
        // Ignore errors and continue importing
    }
}
