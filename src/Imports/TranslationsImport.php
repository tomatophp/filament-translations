<?php

namespace TomatoPHP\FilamentTranslations\Imports;

use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Concerns\ToCollection;
use Modules\TomatoTranslations\App\Models\Translation;
use Illuminate\Support\Collection;
use Spatie\TranslationLoader\LanguageLine;


class TranslationsImport implements ToCollection
{

    public function collection(Collection $rows)
    {
        unset($rows[0]);
        $getLocals = config('filament-translations.locals');

        foreach ($rows as $key=>$row) {
            $langs = config('filament-translations.locals');
            $id = $row[0];
            $getTranslation = LanguageLine::find($id);
            $mergeTranslation = [];
            $count =1;
            foreach ($langs as $langKey=>$lang){
                if(isset($row[$count+1]) && !empty($row[$count+1])){
                    $mergeTranslation[$langKey] = $row[$count+1];
                }
                $count++;
            }
            $getTranslation->text = $mergeTranslation;
            $getTranslation->save();
        }
    }
}
