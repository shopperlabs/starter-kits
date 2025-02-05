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

    @if($product->variants_count > 0)
        <p class="mt-3 text-sm text-gray-500">
            {{ __('+:count variants', ['count' => $product->variants_count]) }}
        </p>
    @endif
</div>
