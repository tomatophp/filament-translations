<?php

namespace TomatoPHP\FilamentTranslations\Services;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Symfony\Component\Finder\SplFileInfo;

class Scan
{
    /**
     * The Filesystem instance.
     *
     * @var Filesystem
     */
    private $disk;

    /**
     * The paths to directories where we look for localised strings to scan.
     *
     * @var array
     */
    private $scannedPaths;

    /**
     * Manager constructor.
     */
    public function __construct(Filesystem $disk)
    {
        $this->disk = $disk;
        $this->scannedPaths = collect([]);
    }

    public function addScannedPath($path): void
    {
        $this->scannedPaths->push($path);
    }

    public function getAllViewFilesWithTranslations(): array
    {
        /*
         * This pattern is derived from Barryvdh\TranslationManager by Barry vd. Heuvel <barryvdh@gmail.com>
         *
         * https://github.com/barryvdh/laravel-translation-manager/blob/master/src/Manager.php
         */
        $functions = [
            'trans',
            'trans_choice',
            'Lang::get',
            'Lang::choice',
            'Lang::trans',
            'Lang::transChoice',
            '@lang',
            '@choice',
            '__',
        ];

        $patternA =
            // See https://regex101.com/r/jS5fX0/4
            '[^\w]' . // Must not start with any alphanum or _
            '(?<!->)' . // Must not start with ->
            '(' . implode('|', $functions) . ')' . // Must start with one of the functions
            "\(" . // Match opening parentheses
            "[\'\"]" . // Match " or '
            '(' . // Start a new group to match:
            '([a-zA-Z0-9_\/-]+::)?' .
            '[a-zA-Z0-9_-]+' . // Must start with group
            "([.][^\1)$]+)+" . // Be followed by one or more items/keys
            ')' . // Close group
            "[\'\"]" . // Closing quote
            "[\),]";  // Close parentheses or new parameter

        $patternB =
            // See https://regex101.com/r/2EfItR/2
            '[^\w]' . // Must not start with any alphanum or _
            '(?<!->)' . // Must not start with ->
            '(__|Lang::getFromJson)' . // Must start with one of the functions
            '\(' . // Match opening parentheses

            '[\"]' . // Match "
            '(' . // Start a new group to match:
            '[^"]+' . // Can have everything except "
            //            '(?:[^"]|\\")+' . //Can have everything except " or can have escaped " like \", however it is not working as expected
            ')' . // Close group
            '[\"]' . // Closing quote

            '[\)]';  // Close parentheses or new parameter

        $patternC =
            // See https://regex101.com/r/VaPQ7A/2
            '[^\w]' . // Must not start with any alphanum or _
            '(?<!->)' . // Must not start with ->
            '(__|Lang::getFromJson)' . // Must start with one of the functions
            '\(' . // Match opening parentheses

            '[\']' . // Match '
            '(' . // Start a new group to match:
            "[^']+" . // Can have everything except '
            //            "(?:[^']|\\')+" . //Can have everything except 'or can have escaped ' like \', however it is not working as expected
            ')' . // Close group
            '[\']' . // Closing quote

            '[\)]';  // Close parentheses or new parameter

        $trans = collect();
        $__ = collect();
        $excludedPaths = config('filament-translations.excludedPaths');

        // FIXME maybe we can count how many times one translation is used and eventually display it to the user

        /** @var SplFileInfo $file */
        foreach ($this->disk->allFiles($this->scannedPaths->toArray()) as $file) {
            $dir = dirname($file);
            if (Str::startsWith($dir, $excludedPaths)) {
                continue;
            }

            if (preg_match_all("/$patternA/siU", $file->getContents(), $matches)) {
                $trans->push($matches[2]);
            }

            if (preg_match_all("/$patternB/siU", $file->getContents(), $matches)) {
                $__->push($matches[2]);
            }

            if (preg_match_all("/$patternC/siU", $file->getContents(), $matches)) {
                $__->push($matches[2]);
            }
        }

        return [$trans->flatten()->unique(), $__->flatten()->unique()];
    }
}
