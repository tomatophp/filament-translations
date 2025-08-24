<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Paths
    |--------------------------------------------------------------------------
    |
    | add path that will be show to the scaner to catch lanuages tags
    |
    */
    'paths' => [
        app_path(),
        resource_path('views'),
        base_path('vendor'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Excluded paths
    |--------------------------------------------------------------------------
    |
    | Put here any folder that you want to exclude that is inside of paths
    |
    */

    'excludedPaths' => [],

    /*
    |--------------------------------------------------------------------------
    | Locals
    |--------------------------------------------------------------------------
    |
    | add the locals that will be show on the languages selector
    |
    */
    'locals' => [
        'en' => [
            'label' => 'English',
            'flag' => 'us',
        ],
        'ar' => [
            'label' => 'Arabic',
            'flag' => 'eg',
        ],
        'fr' => [
            'label' => 'French',
            'flag' => 'fr',
        ],
        'pt_BR' => [
            'label' => 'Português (Brasil)',
            'flag' => 'br',
        ],
        'my' => [
            'label' => 'Burmese',
            'flag' => 'mm',
        ],
        'id' => [
            'label' => 'Indonesia',
            'flag' => 'id',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Modal
    |--------------------------------------------------------------------------
    |
    | use simple modal resource for the translation resource
    |
    */
    'modal' => true,

    /*
    |--------------------------------------------------------------------------
    |
    | Add groups that should be excluded in translation import from files to database
    |
    */
    'exclude_groups' => [],

    /*
     |--------------------------------------------------------------------------
     |
     | Register the navigation for the translations.
     |
     */
    'register_navigation' => true,

    /*
     |--------------------------------------------------------------------------
     |
     | Use Queue to scan the translations.
     |
     */
    'use_queue_on_scan' => true,

    /*
     |--------------------------------------------------------------------------
     |
     | Custom import command.
     |
     */
    'path_to_custom_import_command' => null,

    /*
     |--------------------------------------------------------------------------
     |
     | Show buttons in Translation resource.
     |
     */
    'scan_enabled' => true,
    'export_enabled' => true,
    'import_enabled' => true,

    /*
     |--------------------------------------------------------------------------
     |
     | Translation resource.
     |
     */
    'translation_resource' => \TomatoPHP\FilamentTranslations\Filament\Resources\Translations\TranslationResource::class,

    /*
     |--------------------------------------------------------------------------
     |
     | Custom Excel export.
     |
     */
    'path_to_custom_excel_export' => null,

    /*
     |--------------------------------------------------------------------------
     |
     | Custom Excel import.
     |
     */
    'path_to_custom_excel_import' => null,

    /*
     |--------------------------------------------------------------------------
     |
     | Use Developer Gate.
     |
     */
    'use_developer_gate' => true,

    /*
     |--------------------------------------------------------------------------
     |
     | When use developer gate, hide the navigation.
     |
     */
    'hide_navigation_when_developer_gate' => false,

    /*
     |--------------------------------------------------------------------------
     |
     | Navigation group.
     | it can be a translation key if it's has just . on it.
     |
     */
    'navigation_group' => 'Settings',

    /*
     |--------------------------------------------------------------------------
     |
     | Navigation icon.
     |
     */
    'navigation_icon' => 'heroicon-m-language',
];
