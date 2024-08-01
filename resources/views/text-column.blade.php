<div class="my-4">
    @if(is_array($getState()))
        <div>
            @foreach($getState() as $key=>$item)
                <div class="flex justifiy-start gap-4 my-2">
                    <div class="border dark:border-gray-700 rounded-full" style="padding-left: 10px; padding-right: 10px">
                        {{ config('filament-translations.locals')[$key]['label'] }}
                    </div>
                    <div>{{ $item }}</div>
                </div>
            @endforeach
        </div>
    @endif
</div>
