@props([
    'spa' => true,
])

<a
    {{ $attributes }}
    @if($spa)
        wire:navigate
    @endif
>{{ $slot }}</a>
