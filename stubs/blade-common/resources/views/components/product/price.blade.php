@props([
    'product',
])

@php
    $price = $product->getPrice();
@endphp

<p {{ $attributes->twMerge(['class' => 'inline-flex items-center gap-2 text-sm font-medium text-gray-900']) }}>
    <span>{{ $price?->value->formatted }}</span>

    @if($price && $price->percentage && $price->percentage > 0)
        <span>
            <span class="sr-only">{{ __('Original :') }}</span>
            <span class="text-gray-400 font-normal line-through">
                {{ $price->compare->formatted }}
            </span>
            <x-discount-badge
                :discount="$price->percentage"
                class="ml-2"
            />
        </span>
    @endif
</p>
