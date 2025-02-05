@props([
    'product',
    'categories',
])

<div class="mt-10 space-y-10 border-t border-gray-200 pt-8">
    <div>
        <h2 class="text-sm font-medium text-gray-900">{{ __('Measurements and specifications') }}</h2>

        <div class="text-sm mt-6 text-gray-500 lg:max-w-xs">
            <ul role="list" class="divide-y divide-gray-100">
                <li class="grid grid-cols-2 gap-2 py-2">
                    <span>{{ __('Category') }} :</span>
                    <span class="text-gray-700 text-sm font-medium">
                        {{ $categories }}
                    </span>
                </li>
                <li class="grid grid-cols-2 gap-2 py-2">
                    <span>{{ __('Height') }} :</span>
                    <span class="text-gray-700 font-medium">
                        {{ \Illuminate\Support\Number::format($product->height_value ?? 0) }} {{ $product->height_unit->value }}
                    </span>
                </li>
                <li class="grid grid-cols-2 gap-2 py-2">
                    <span>{{ __('Width') }} :</span>
                    <span class="text-gray-700 font-medium">
                        {{ \Illuminate\Support\Number::format($product->width_value ?? 0) }} {{ $product->width_unit->value }}
                    </span>
                </li>
                <li class="grid grid-cols-2 gap-2 py-2">
                    <span>{{ __('Depth') }} :</span>
                    <span class="text-gray-700 font-medium">
                        {{ \Illuminate\Support\Number::format($product->depth_value ?? 0) }} {{ $product->depth_unit->value }}
                    </span>
                </li>
                <li class="grid grid-cols-2 gap-2 py-2">
                    <span>{{ __('Weight') }} :</span>
                    <span class="text-gray-700 font-medium">
                        {{ \Illuminate\Support\Number::format($product->weight_value ?? 0) }} {{ $product->weight_unit->value }}
                    </span>
                </li>
            </ul>
        </div>
    </div>
</div>
