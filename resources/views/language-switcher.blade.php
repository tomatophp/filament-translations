@php
if(!function_exists('try_svg')) {
    function try_svg($name, $classes) {
        try {
            return svg($name, $classes);
        }
        catch(\Exception $e) {
            return '❓';
        }
    }
}
@endphp

<div x-data="{
        toggle: function (event) {
            $refs.panel.toggle(event)
        },
        open: function (event) {
            $refs.panel.open(event)
        },
        close: function (event) {
            $refs.panel.close(event)
        },
    }">

    <button
        @class([
            'block hover:opacity-75',
        ])
        id="filament-language-switcher"
        x-on:click="toggle"
    >
        <div
            @class([
                'flex items-center justify-center rounded-sm bg-cover bg-center',
                'w-8 h-6 bg-gray-200 dark:bg-gray-900'
            ])
            style="background-image: url('https://cdn.jsdelivr.net/gh/hampusborgos/country-flags@main/svg/{{config('filament-translations.locals')[app()->getLocale()]['flag']?:null}}.svg')"
        >

        </div>
    </button>

    <div x-ref="panel" x-float.placement.bottom-end.flip.offset="{ offset: 8 }" x-transition:enter-start="opacity-0 scale-95" x-transition:leave-end="opacity-0 scale-95" class="ffi-dropdown-panel absolute z-10 divide-y divide-gray-100 rounded-lg bg-white shadow-lg ring-1 ring-gray-950/5 transition dark:divide-white/5 dark:bg-gray-900 dark:ring-white/10 max-w-[14rem]" style="display: none; left: 1152px; top: 59.5px;">
        <div class="filament-dropdown-list p-1">
            @foreach ($otherLanguages as $key=>$language)
                @php $isCurrent = app()->getLocale() === $key; @endphp
                <a
                    @class([
                        'filament-dropdown-list-item filament-dropdown-item group flex items-center whitespace-nowrap rounded-md p-2 text-sm outline-none text-gray-500 dark:text-gray-200',
                        'hover:bg-gray-50 focus:bg-gray-50 dark:hover:bg-white/5 dark:focus:bg-white/5 hover:text-gray-700 focus:text-gray-500 dark:hover:text-gray-200 dark:focus:text-gray-400' => !$isCurrent,
                        'cursor-default' => $isCurrent,
                    ])
                    @if (!$isCurrent)
                        href="{{ route('filament-translations.switcher', ['lang' => $key, 'model' => get_class(auth()->user()), 'model_id' => \Filament\Facades\Filament::auth()->user()->id]) }}"
                    @endif
                >
                    <span class="filament-dropdown-list-item-label truncate text-start flex justify-content-start gap-3">
                       <div
                            @class([
                                'w-6 h-4'
                            ])
                            style="background-image: url('https://cdn.jsdelivr.net/gh/hampusborgos/country-flags@main/svg/{{$language['flag']}}.svg')"
                        >

                        </div>
                        <span @class(['font-semibold' => $isCurrent])>{{ trans('filament-translations::translation.lang.'.$key) }}</span>
                    </span>
                </a>
            @endforeach
        </div>
    </div>
</div>
