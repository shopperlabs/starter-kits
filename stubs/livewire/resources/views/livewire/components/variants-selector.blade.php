<div>
    <form class="space-y-10" wire:submit="addToCart">
        @if($product->isVariant() && $this->productOptions->isNotEmpty())
            <div class="space-y-8">
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
            <span class="absolute left-0 pl-2" wire:loading>
                <x-loading-dots class="bg-white" />
            </span>
            {{ __('Add to cart') }}
        </x-buttons.primary>
    </form>
</div>
