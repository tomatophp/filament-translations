![Screenshot of Login](https://github.com/tomatophp/filament-translations/blob/master/arts/3x1io-tomato-translations.jpg)

# Filament translations

[![Latest Stable Version](https://poser.pugx.org/tomatophp/filament-translations/version.svg)](https://packagist.org/packages/tomatophp/filament-translations)
[![PHP Version Require](http://poser.pugx.org/tomatophp/filament-translations/require/php)](https://packagist.org/packages/tomatophp/filament-translations)
[![License](https://poser.pugx.org/tomatophp/filament-translations/license.svg)](https://packagist.org/packages/tomatophp/filament-translations)
[![Downloads](https://poser.pugx.org/tomatophp/filament-translations/d/total.svg)](https://packagist.org/packages/tomatophp/filament-translations)

Manage your translation with DB and cache, you can scan your languages tags like `trans()`, `__()`, and get the string inside and translate them use UI.

this plugin is build in [spatie/laravel-translation-loader](https://github.com/spatie/laravel-translation-loader)

## Screenshots

![Screenshot of list](https://github.com/tomatophp/filament-translations/blob/master/arts/list-view.png)
![Screenshot of edit](https://github.com/tomatophp/filament-translations/blob/master/arts/edit-view.png)
![Screenshot of settings](https://github.com/tomatophp/filament-translations/blob/master/arts/setting-view.png)

## Installation

```bash
composer require tomatophp/filament-translations
```

## Publish Resource

you can publish the resource to your project

```bash
php artisan vendor:publish --tag="filament-translations-migrations"
```

if you need to publish config

```bash
php artisan vendor:publish --tag="filament-translations-config"
```

Run migration:

```bash
php artisan migrate
```

and now clear cache

```bash
php artisan optimize:clear
```

finally reigster the plugin on `/app/Providers/Filament/AdminPanelProvider.php`

```php
$panel->plugin(\TomatoPHP\FilamentTranslations\FilamentTranslationsPlugin::make())
```

## Scan Using Command Line

you can scan your project to get all the languages tags and save them to the database


```bash
php artisan filament-translations:import
```

## Change Scan to work on Queue

on your config file just change the `use_queue_on_scan` to `true`

```php

'use_queue_on_scan' => true,

```

## Publish Assets

you can publish config file by use this command

```bash
php artisan vendor:publish --tag="filament-translations-config"
```

you can publish views file by use this command

```bash
php artisan vendor:publish --tag="filament-translations-views"
```

you can publish languages file by use this command

```bash
php artisan vendor:publish --tag="filament-translations-lang"
```

you can publish migrations file by use this command

```bash
php artisan vendor:publish --tag="filament-translations-migrations"
```

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
