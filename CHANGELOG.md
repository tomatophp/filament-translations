### V5.0.0

- upgrade to Filament v5 and Livewire 4 (Laravel 12 and 13, PHP 8.2+)
- support `maatwebsite/excel` 3.1 and 4.0
- fix the scan missing JSON strings that are followed by parameters, e.g. `__('Hello :name', [...])` (#53)
- fix the scan storing a group key twice (once as a JSON string) and saving the key itself as the text (#40)
- fix header, table and page actions being duplicated when the plugin boots on every request under Laravel Octane (#46)
- register a policy for the translation model: `filament-translations.policy`, or `App\Policies\TranslationPolicy` when it exists (#44)
- the scan and import actions respect the policy `create` ability, the clear action `deleteAny`
- the Excel import keeps the stored text of locales left empty in the file and skips rows that no longer exist
- `filament-translations:install` runs in-process; `filament-translations:scan` asks for the path when missing and creates `resources/lang`
- add tests for the scan, commands, Excel import/export, policy and Octane behaviour
