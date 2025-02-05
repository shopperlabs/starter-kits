<div>
    <div class="space-y-4">
        <h1 class="font-heading text-xl font-semibold text-gray-900 lg:text-2xl">
            {{ $product->name }}

            @if ($this->variant)
                {{ $this->variant->name }}
            @endif
        </h1>

        <x-product.price
            :product="$this->variant ?? $product"
            class="text-lg font-bold text-brand lg:text-2xl"
        />
    </div>

    <form class="mt-6 space-y-10" wire:submit="addToCart">
        @if($product->isVariant() && $this->productOptions->isNotEmpty())
            <div class="space-y-5">
                @foreach ($this->productOptions as $option)
                    @if(\Illuminate\Support\Facades\View::exists('components.attributes.'.$option->attribute->slug))
                        <x-dynamic-component
                            :component="'attributes.'.$option->attribute->slug"
                            :option="$option"
                        />
                    @else
                        <x-attributes :option="$option" />
                    @endif
                @endforeach
            </div>
        @endif

        @if($product->isVariant() && $this->productOptions->isEmpty())
            <div class="grid grid-cols-3 gap-3">
                @foreach($this->variants as $variant)
                    <button
                        type="button"
                        wire:key="{{ $variant->id }}"
                        x-on:click="$wire.set('selectedVariantId', {{ $variant->id }})"
                        @class([
                            'inline-flex flex-col items-center gap-1 overflow-hidden text-sm/5 text-gray-500 px-2 py-1.5 ring-1 ring-gray-100 hover:ring-gray-200',
                            'ring-2 ring-primary-600' => $variant->id === $selectedVariantId
                        ])
                    >
                        <img
                            src="{{ $variant->getFirstMediaUrl(config('shopper.media.storage.thumbnail_collection')) }}"
                            alt=""
                            class="object-center object-cover max-w-none h-14 w-full"
                        >
                        <span>{{ $variant->name }}</span>
                    </button>
                @endforeach
            </div>
        @endif

        <x-buttons.primary
            type="submit"
            class="w-full px-8 py-3 text-base"
            wire:loading.attr="disabled"
            wire:target="addToCart"
            :disabled="
                $product->isVariant() && ! $this->variant ||
                $product->isVariant() && $this->variant && $this->variant->stock < 1 ||
                ! $product->isVariant() && $product->stock < 1
            "
        >
            <span class="absolute left-0 top-0 pl-2">
                <x-phosphor-shopping-bag-duotone class="size-6 text-white" aria-hidden="true" wire:loading.remove />
                <x-loading-dots class="bg-white hidden" aria-hidden="true" wire:loading.class="block" />
            </span>
            {{ __('Add to cart') }}
        </x-buttons.primary>
    </form>
</div>
