# Filament translations

Manage your translation with DB and cache, you can scan your languages tags like trans(), __(), and get the string inside and translate them use UI.

## Installation

```bash
composer require tomatophp/filament-translations
```
after install your package please run this command

```bash
php artisan filament-translations:install
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

you can join our discord server to get support [TomatoPHP](https://discord.gg/Xqmt35Uh)

## Docs

you can check docs of this package on [Docs](https://docs.tomatophp.com/plugins/laravel-package-generator)

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Security

Please see [SECURITY](SECURITY.md) for more information about security.

## Credits

- [Tomatophp](mailto:info@3x1.io)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
