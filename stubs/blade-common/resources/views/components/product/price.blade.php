@props([
    'product',
])

@php
    $price = $product->getPrice();
@endphp

<p {{ $attributes->twMerge(['class' => 'inline-flex flex-col gap-0.5 text-sm']) }}>
    <span class="font-semibold text-primary-600 lining-nums slashed-zero">
        {{ $price?->value->formatted }}
    </span>

    @if($price && $price->percentage && $price->percentage > 0)
        <span>
            <span class="sr-only">{{ __('Original :') }}</span>
            <span class="text-gray-400 font-normal text-[13px] line-through">
                {{ $price->compare->formatted }}
            </span>
            <x-discount-badge
                :discount="$price->percentage"
                class="ml-2"
            />
        </span>
    @endif
</p>
