![Screenshot of Login](https://raw.githubusercontent.com/tomatophp/filament-translations/master/arts/3x1io-tomato-translations.jpg)

## Documentation

1. [Filament translations](#filament-translations)
2. [Screenshots](#screenshots)
3. [Installation](#installation)
    - [Allow ChatGPT Auto Translations](#allow-chatgpt-auto-translations)
    - [Allow Google Translate Auto Translations](#allow-google-translate-auto-translations)
    - [Allow Create Button to Create New Language](#allow-create-button-to-create-new-language)
    - [Allow Clear All Translations Button](#allow-clear-all-translations-button)
    - [Publish Resource](#publish-resource)
    - [Publish Assets](#publish-assets)
4. [Use Language Switcher](#use-language-switcher)
5. [Usage](#usage)
    - [Scan Using Command Line](#scan-using-command-line)
    - [Change Scan to work on Queue](#change-scan-to-work-on-queue)
    - [Custom Import Command](#custom-import-command)
    - [Show or hide buttons in the UI](#show-or-hide-buttons-in-the-ui)
6. [Other Filament Packages](#other-filament-packages)
7. [Support](#support)
8. [Docs](#docs)
9. [Changelog](#changelog)
10. [Security](#security)
11. [Credits](#credits)
12. [License](#license)

# Filament translations

[![Latest Stable Version](https://poser.pugx.org/tomatophp/filament-translations/version.svg)](https://packagist.org/packages/tomatophp/filament-translations)
[![PHP Version Require](http://poser.pugx.org/tomatophp/filament-translations/require/php)](https://packagist.org/packages/tomatophp/filament-translations)
[![License](https://poser.pugx.org/tomatophp/filament-translations/license.svg)](https://packagist.org/packages/tomatophp/filament-translations)
[![Downloads](https://poser.pugx.org/tomatophp/filament-translations/d/total.svg)](https://packagist.org/packages/tomatophp/filament-translations)

Manage your translation with DB and cache, you can scan your languages tags like `trans()`, `__()`, and get the string inside and translate them use UI.

this plugin is build in [spatie/laravel-translation-loader](https://github.com/spatie/laravel-translation-loader)

## Screenshots

![Screenshot of list](https://raw.githubusercontent.com/tomatophp/filament-translations/master/arts/list-view.png)
![Screenshot of edit](https://raw.githubusercontent.com/tomatophp/filament-translations/master/arts/edit-view.png)
![Screenshot of settings](https://raw.githubusercontent.com/tomatophp/filament-translations/master/arts/setting-view.png)

## Installation

```bash
composer require tomatophp/filament-translations
```

Finally reigster the plugin on `/app/Providers/Filament/AdminPanelProvider.php`

```php
$panel->plugin(\TomatoPHP\FilamentTranslations\FilamentTranslationsPlugin::make())
```


### Allow ChatGPT Auto Translations

If you want to use ChatGPT to auto-translate your languages, you need to install `OpenAI` package by running:

```bash
composer require openai-php/laravel
```

now you need to add the following to your `.env` file:

```bash
OPENAI_API_KEY=
OPENAI_ORGANIZATION=
```

allow the feature on your panel provider by adding the following:

```php
$panel->plugin(\TomatoPHP\FilamentTranslations\FilamentTranslationsPlugin::make()->allowGPTScan())
```


### Allow Google Translate Auto Translations

If you want to use Google Translate for auto-translating your languages, you need to install the `stichoza/google-translate` package by running:

```bash
composer require stichoza/google-translate-php
```

Enable the feature on your admin panel provider file by adding the following:

```php
$panel->plugin(\TomatoPHP\FilamentTranslations\FilamentTranslationsPlugin::make()->allowGoogleTranslateScan())
```

### Allow Create Button to Create New Language

If you want to allow the user to create a new language, you need to add the following to your panel provider:

```php
$panel->plugin(\TomatoPHP\FilamentTranslations\FilamentTranslationsPlugin::make()->allowCreate())
```

### Allow Clear All Translations Button

If you want to allow the user to clear all translations, you need to add the following to your panel provider:

```php
$panel->plugin(\TomatoPHP\FilamentTranslations\FilamentTranslationsPlugin::make()->allowClearTranslations())
```

### Publish Resource

You can publish the resource to your project using:

```bash
php artisan vendor:publish --tag="filament-translations-migrations"
```

If you need to publish config run:

```bash
php artisan vendor:publish --tag="filament-translations-config"
```

Run migration:

```bash
php artisan migrate
```

and now clear cache running:

```bash
php artisan optimize:clear
```

### Publish Assets

You can publish views file by use this command:

```bash
php artisan vendor:publish --tag="filament-translations-views"
```

You can publish languages file by use this command:

```bash
php artisan vendor:publish --tag="filament-translations-lang"
```

You can publish migrations file by use this command:

```bash
php artisan vendor:publish --tag="filament-translations-migrations"
```

## Use Language Switcher

You can use the language switcher in your panel by using the following plugin:

```php
$panel->plugin(\TomatoPHP\FilamentTranslations\FilamentTranslationsSwitcherPlugin::make())
```

**NOTE** your auth user table must have `lang` filed on the table to make this switch working fine.

## Usage

### Scan Using Command Line

You can scan your project to get all the languages tags and save them to the database

```bash
php artisan filament-translations:import
```

### Change Scan to work on Queue

In your config file just change the `use_queue_on_scan` to `true`

```php

'use_queue_on_scan' => true,

```

### Custom Import Command

You can create your own command to import the translations, add your custom import class to the config file like this:

```php
'path_to_custom_import_command' => ImportTranslations::class,
```

This command will automatically run when you click on the "Scan For New Languages" button in the UI.

### Custom Excel Import

You can create your own Excel import to import the translations, add your custom import class to the config file like this:

```php
'path_to_custom_excel_import' => CustomTranslationImport::class,
```

The import class is based on the Laravel Excel package.
You can check the documentation [here](https://docs.laravel-excel.com/3.1/imports/).
This import will automatically run when you click on the "Import" button in the UI.

### Custom Excel Export

You can create your own Excel export to export the translations in your own format, add your custom export class to the config file like this:

```php
'path_to_custom_excel_export' => CustomTranslationExport::class,
```

The export class is based on the Laravel Excel package.
You can check the documentation [here](https://docs.laravel-excel.com/3.1/imports/).
This import will automatically run when you click on the "Export" button in the UI.

### Show or hide buttons in the UI

You can show or hide the buttons in the UI by changing the config file. By default, all buttons are shown.

```php
    'show_import_button' => true,
    'show_export_button' => false,
    'show_scan_button' => false ,
```

### Custom Resource

You can create your own resource to show the translations in the UI, add your custom resource class to the config file like this:

```php
    'translation_resource' => CustomResource::class,
```

This is especially useful when you want to have complete control over the UI but still want to use the translations package. Think about implementing a check on user roles when using `shouldRegisterNavigation` in your custom resource.

## Other Filament Packages

- [Filament Users Resource](https://www.github.com/tomatophp/filament-users)
- [Filament Settings Hub](https://www.github.com/tomatophp/filament-settings-hub)
- [Filament Menus Generator](https://www.github.com/tomatophp/filament-menus)
- [Filament Alerts Sender](https://www.github.com/tomatophp/filament-alerts)
- [Filament Accounts Builder](https://www.github.com/tomatophp/filament-accounts)
- [Filament Wallet Manager](https://www.github.com/tomatophp/filament-wallet)
- [Filament Artisan Runner](https://www.github.com/tomatophp/filament-artisan)
- [Filament File Browser](https://www.github.com/tomatophp/filament-browser)
- [Filament Developer Gate](https://www.github.com/tomatophp/filament-developer-gate)
- [Filament Locations Seeder](https://www.github.com/tomatophp/filament-locations)
- [Filament Plugins Manager](https://www.github.com/tomatophp/filament-plugins)
- [Filament Splade Integration](https://www.github.com/tomatophp/filament-splade)
- [Filament Types Manager](https://www.github.com/tomatophp/filament-types)
- [Filament Icons Picker](https://www.github.com/tomatophp/filament-icons)
- [Filament Helpers Classes](https://www.github.com/tomatophp/filament-helpers)


## Support

you can join our discord server to get support [TomatoPHP](https://discord.gg/VZc8nBJ3ZU)

## Docs

you can check docs of this package on [Docs](https://docs.tomatophp.com/filament/filament-translations)

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Security

Please see [SECURITY](SECURITY.md) for more information about security.

## Credits

- [Tomatophp](mailto:info@3x1.io)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
