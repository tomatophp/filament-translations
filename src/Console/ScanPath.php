<?php

namespace TomatoPHP\FilamentTranslations\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use TomatoPHP\ConsoleHelpers\Traits\HandleFiles;
use TomatoPHP\ConsoleHelpers\Traits\RunCommand;
use TomatoPHP\FilamentTranslations\Services\Scan;
use function Laravel\Prompts\error;
use function Laravel\Prompts\info;
use function Laravel\Prompts\text;

class ScanPath extends Command
{
    use RunCommand;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'filament-translations:scan {path?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'scan selected path for translations and put it in json file';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $path = $this->argument('path');

        if(!$path){
            text('Please enter path to scan', required: true);
        }

        $checkIfPathExists = File::exists($path);
        while (!$checkIfPathExists){
            error('Path does not exist');
            $path = text('Please enter path to scan', required: true);
            $checkIfPathExists = File::exists($path);
        }

        info('Scanning path: ' . $path);

        $scanner = app(Scan::class);
        $scanner->addScannedPath($path);

        list($trans, $__) = $scanner->getAllViewFilesWithTranslations();

        //TODO: save translations to array file
//        $trans->each(function ($trans) {
//            list($group, $key) = explode('.', $trans, 2);
//            $namespaceAndGroup = explode('::', $group, 2);
//            if (count($namespaceAndGroup) === 1) {
//                $namespace = '*';
//                $group = $namespaceAndGroup[0];
//            } else {
//                list($namespace, $group) = $namespaceAndGroup;
//            }
//            $this->createOrUpdate($namespace, $group, $key);
//        });

        /** @var Collection $__ */

        $collectKeys = collect([]);
        $__->each(function ($default) use ($collectKeys) {
            if(((!str_contains($default, '{{')) && (!str_contains($default, '}}')) && (!str_contains($default, '::'))  && (!str_contains($default, '.$')))){
                $collectKeys->put($default, $default);
            }
        });

        $checkIfPathHasLang = File::exists($path.'/resources/lang');
        if(!$checkIfPathHasLang){
            File::makeDirectory($path.'/resources/lang');
        }

        $jsonFileContent = json_encode($collectKeys->toArray(), JSON_PRETTY_PRINT);

        File::put($path.'/resources/lang/en.json', $jsonFileContent);

        info('Translations saved to: ' . $path.'/resources/lang/en.json');
    }
}
