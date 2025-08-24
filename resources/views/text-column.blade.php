<div class="my-4">
    @if(is_array($getState()))
        <div>
            @foreach($getState() as $key=>$item)
                <div class="fi-sidebar-group-btn ">
                    <div>
                        <x-filament::badge>
                            {{ config('filament-translations.locals')[$key]['label'] }}
                        </x-filament::badge>
                    </div>
                    <div x-tooltip="{content: '{{ $item }}', theme: $store.theme}">{{ \Str::limit($item, 30) }}</div>
                </div>
            @endforeach
        </div>
    @endif
</div>
