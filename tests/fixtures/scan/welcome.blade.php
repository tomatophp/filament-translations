<div>
    <h1>{{ __('Welcome back :name', ['name' => $user->name]) }}</h1>
    <p>{{ __("Signed in as :email", ['email' => $user->email]) }}</p>
    <p>{{ __('Plain string') }}</p>
    <p>{{ trans('messages.welcome', ['name' => $user->name]) }}</p>
    <p>{{ __('messages.goodbye') }}</p>
    <p>{{ __('filament-translations::translation.label') }}</p>
</div>
