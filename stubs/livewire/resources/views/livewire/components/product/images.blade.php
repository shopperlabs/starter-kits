<?php

declare(strict_types=1);

use App\Models\ProductVariant;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\On;
use Livewire\Volt\Component;

new #[Lazy(isolate: false)] class extends Component
{
    /**
     * @var string[]
     */
    public array $images = [];

    public string $thumbnail = '';

    public function placeholder(): string
    {
        return <<<'BLADE'
        <div class="space-y-6">
            <div>
                <x-shopper::skeleton class="h-[27.35rem] rounded-none ring-gray-100" />
            </div>
            <div class="grid grid-cols-3 gap-6">
                <x-shopper::skeleton class="rounded-none ring-gray-100 h-32 w-full" />
                <x-shopper::skeleton class="rounded-none ring-gray-100 h-32 w-full" />
                <x-shopper::skeleton class="rounded-none ring-gray-100 h-32 w-full" />
            </div>
        </div>
        BLADE;
    }

    #[On('variant.selected')]
    public function variantSelected(?int $variantId = null): void
    {
        if ($variantId) {
            $variant = ProductVariant::with('media', 'product.media')
                ->select('product_id', 'id')
                ->find($variantId);

            $this->thumbnail = $variant->getMedia(config('shopper.media.storage.thumbnail_collection'))->isNotEmpty()
                ? $variant->getFirstMediaUrl(config('shopper.media.storage.thumbnail_collection'))
                : $variant->product->getFirstMediaUrl(config('shopper.media.storage.thumbnail_collection'));

            $this->images = $variant->getMedia(config('shopper.media.storage.collection_name'))->isNotEmpty()
                ? $variant->getMedia(config('shopper.media.storage.collection_name'))
                    ->map(fn ($media) => $media->getUrl())
                    ->toArray()
                : $variant->product->getMedia(config('shopper.media.storage.collection_name'))
                    ->map(fn ($media) => $media->getUrl())
                    ->toArray();
        }
    }
} ?>

<div class="space-y-6">
    <div class="aspect-1/2 overflow-hidden">
        <img
            src="{{ $thumbnail }}"
            alt="product thumbnail"
            class="size-full object-cover max-w-none object-center"
        />
    </div>

    @if (count($images))
        <x-product.gallery :$images />
    @endif
</div>
