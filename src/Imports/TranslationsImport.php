<?php

namespace TomatoPHP\FilamentTranslations\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Spatie\TranslationLoader\LanguageLine;

class TranslationsImport implements ToCollection
{
    public function collection(Collection $rows): void
    {
        unset($rows[0]);

        $locales = array_keys(config('filament-translations.locals'));

        foreach ($rows as $row) {
            $translation = LanguageLine::find($row[0] ?? null);

            if (! $translation) {
                continue;
            }

            // Columns: id, key, then one column per configured locale. Empty cells keep the stored text.
            $imported = [];
            foreach ($locales as $index => $locale) {
                $value = $row[$index + 2] ?? null;

                if (filled($value)) {
                    $imported[$locale] = $value;
                }
            }

            $translation->text = array_merge($translation->text ?? [], $imported);
            $translation->save();
        }
    }
}
