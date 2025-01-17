<?php

declare(strict_types=1);

namespace App\Livewire\Pages;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

/**
 * @property-read ProductVariant $selectedVariant
 */
class SingleProduct extends Component
{
    public ?Product $product = null;

    /**
     * Selected Variants values
     */
    public array $values = [];

    public function mount(string $slug): void
    {
        $this->product = Product::with([
            'media',
            'prices' => function ($query): void {
                $query->whereRelation('currency', 'code', current_currency());
            },
            'prices.currency',
            'inventoryHistories',
        ])
            ->where('slug', $slug)
            ->firstOrFail();
    }

    #[On('variant.selected')]
    public function values(array $values = []): void
    {
        $this->values = $values;
    }

    #[Computed]
    public function selectedVariant(): ?ProductVariant
    {
        return $this->product->variants
            ->load([
                'inventoryHistories',
                'values',
                'media',
                'prices' => function ($query): void {
                    $query->whereRelation('currency', 'code', current_currency());
                },
                'prices.currency',
            ])
            ->first(function ($variant) {
                return ! $variant->values->pluck('id')
                    ->diff(array_values($this->values))
                    ->count();
            });
    }

    #[Computed]
    public function thumbnail(): string
    {
        if ($this->selectedVariant && $this->selectedVariant->getMedia(config('shopper.media.storage.thumbnail_collection'))->isNotEmpty()) {
            return $this->selectedVariant->getFirstMediaUrl(config('shopper.media.storage.thumbnail_collection'));
        }

        return $this->product->getFirstMediaUrl(config('shopper.media.storage.thumbnail_collection'));
    }

    #[Computed]
    public function images(): Collection
    {
        if ($this->selectedVariant && $this->selectedVariant->getMedia(config('shopper.media.storage.collection_name'))->isNotEmpty()) {
            return $this->selectedVariant->getMedia(config('shopper.media.storage.collection_name'));
        }

        return $this->product->getMedia(config('shopper.media.storage.collection_name'));
    }

    public function render(): View
    {
        return view('livewire.pages.single-product')
            ->title($this->product->name);
    }
}
