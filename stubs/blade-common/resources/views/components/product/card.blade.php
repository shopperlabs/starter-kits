@props([
    'product',
])

<div class="group relative">
    <x-product.thumbnail :product="$product" />

    <div class="mt-4 flex justify-between">
        <div>
            <h3 class="text-sm font-medium text-gray-700">
                <x-link :href="route('single-product', $product->slug)">
                    <span aria-hidden="true" class="absolute inset-0"></span>
                    {{ $product->name }}
                </x-link>
            </h3>

            @if ($product->brand_id)
                <p class="mt-1 text-sm text-gray-500">
                    {{ $product->brand->name }}
                </p>
            @endif
        </div>
        <x-product.price :product="$product" />
    </div>
</div>
