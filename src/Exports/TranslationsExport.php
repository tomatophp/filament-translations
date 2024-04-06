<?php

namespace TomatoPHP\FilamentTranslations\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Spatie\TranslationLoader\LanguageLine;
use Maatwebsite\Excel\Concerns\WithMapping;

class TranslationsExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return LanguageLine::all();
    }

    public function map($line): array
    {
        $exportArray = [
            $line->id,
            $line->key,
        ];

        $locales = config('filament-translations.locals');
        foreach ($locales as $key=>$value){
            $exportArray[] = $line->text[$key] ?? null;
        }

        return $exportArray;
    }

    public function headings(): array
    {
        $headers = [
            "id",
            "key",
        ];

        $locales = config('filament-translations.locals');
        foreach ($locales as $key=>$value){
            $headers[] = $value["label"];
        }

        return $headers;
    }
}
