<?php

namespace TomatoPHP\FilamentTranslations\Services;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;
use TomatoPHP\FilamentTranslations\Models\Translation;

class Manager
{
    /** @var \Illuminate\Filesystem\Filesystem */
    protected $files;

    protected $locales;

    public function __construct(Filesystem $files)
    {
        $this->files = $files;
        $this->locales = [];
    }

    public function importTranslations($replace = false, $base = null, $import_group = false)
    {
        $counter = 0;
        //allows for vendor lang files to be properly recorded through recursion.
        $vendor = true;
        if ($base === null) {
            $base = lang_path();
            $vendor = false;
        }

        foreach ($this->files->directories($base) as $langPath) {
            $locale = basename($langPath);
            //import langfiles for each vendor
            if ($locale === 'vendor') {
                foreach ($this->files->directories($langPath) as $vendor) {
                    $counter += $this->importTranslations($replace, $vendor);
                }

                continue;
            }
            $vendorName = $this->files->name($this->files->dirname($langPath));

            foreach ($this->files->allfiles($langPath) as $file) {
                $info = pathinfo($file);
                $group = $info['filename'];
                if ($import_group) {
                    if ($import_group !== $group) {
                        continue;
                    }
                }

                if (in_array($group, config('filament-translations.exclude_groups'))) {
                    continue;
                }
                $subLangPath = str_replace($langPath.DIRECTORY_SEPARATOR, '', $info['dirname']);
                $subLangPath = str_replace(DIRECTORY_SEPARATOR, '/', $subLangPath);
                $langPath = str_replace(DIRECTORY_SEPARATOR, '/', $langPath);

                if ($subLangPath != $langPath) {
                    $group = $subLangPath.'/'.$group;
                }

                if (! $vendor) {
                    $translations = \Lang::getLoader()->load($locale, $group);
                } else {
                    $translations = include $file;
                    $group = 'vendor/'.$vendorName.'/'.$group;
                }

                if ($translations && is_array($translations)) {
                    foreach (Arr::dot($translations) as $key => $value) {
                        $importedTranslation = $this->importTranslation($key, $value, $locale, $group, $replace);
                        $counter += $importedTranslation ? 1 : 0;
                    }
                }
            }
        }

        return $counter;
    }

    public function importTranslation($key, $value, $locale, $group, $replace = false)
    {

        // process only string values
        if (is_array($value)) {
            return false;
        }
        $value = (string) $value;
        $translation = Translation::firstOrNew([
            'group'  => $group,
            'key'    => $key,
        ]);

        $text = $translation->text;

        if(empty($text[$locale])) {
            $text[$locale] = $value;
            $replace = true;
        }

        // Check if the database is different then the files
        if ($text[$locale] !== $value) {
            $text[$locale] = $value;
            $replace = true;
        }

        if ($replace) {
            $translation->text = $text;
        }

        $translation->save();

        return true;
    }
}
