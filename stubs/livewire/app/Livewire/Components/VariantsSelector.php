<?php

declare(strict_types=1);

namespace App\Livewire\Components;

use App\DTO\OptionData;
use App\Models\Product;
use App\Models\ProductVariant;
use Darryldecode\Cart\Facades\CartFacade;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Computed;
use Livewire\Component;

/**
 * @property-read Collection $productOptionValues
 * @property-read Collection $productOptions
 * @property-read Collection $variants
 * @property-read ProductVariant | null $variant
 */
class VariantsSelector extends Component
{
    public Product $product;

    public ?int $selectedVariantId = null;

    public array $selectedOptionValues = [];

    public function addToCart(): void
    {
        $model = $this->variant ?? $this->product;

        if (! $model->getPrice()) {
            Notification::make()
                ->title(__('Cart Error'))
                ->body(__('You cannot add product without price in you cart'))
                ->danger()
                ->send();

            return;
        }

        CartFacade::session(session()->getId())->add([
            'id' => $model->created_at->timestamp * $model->id,
            'name' => $this->product->name,
            'price' => $model->getPrice()->value->amount,
            'quantity' => 1,
            'attributes' => $this->variant
                ? $this->getVariantAttributes()
                : [],
            'associatedModel' => $model,
        ]);

        Notification::make()
            ->title(__('Cart updated'))
            ->body(__('Product / variant has been added to your cart'))
            ->success()
            ->send();

        $this->dispatch('cartUpdated');
    }

    #[Computed(persist: true)]
    public function variants(): Collection
    {
        return Cache::remember(
            key: 'product.'. $this->product->id .'.variants',
            ttl: now()->addWeek(),
            callback: fn () => $this->product
                ->variants
                ->load([
                    'inventoryHistories',
                    'media',
                    'values',
                    'values.attribute',
                    'prices.currency',
                ])
        );
    }

    #[Computed]
    public function variant(): ?ProductVariant
    {
        if ($this->productOptions->isNotEmpty()) {
            return $this->selectVariantUsingOption();
        }

        if ($this->selectedVariantId) {
            $this->dispatch('variant.selected', variantId: $this->selectedVariantId);

            return $this->variants->firstWhere('id', $this->selectedVariantId);
        }

        return null;
    }

    #[Computed]
    public function productOptionValues(): Collection
    {
        return $this->variants->pluck('values')->flatten();
    }

    #[Computed]
    public function productOptions(): Collection
    {
        return $this->productOptionValues
            ->unique('id')
            ->groupBy('attribute_id')
            ->map(function ($values) {
                return new OptionData(
                    attribute: $values->first()->attribute,
                    values: $values,
                );
            })->values();
    }

    protected function selectVariantUsingOption(): ?ProductVariant
    {
        if (! count($this->selectedOptionValues)) {
            return null;
        }

        $variant = $this->variants
            ->first(
                fn ($variant) => ! $variant->values->pluck('id')
                    ->diff(collect($this->selectedOptionValues)->values())
                    ->count()
            );

        if ($variant) {
            $this->dispatch('variant.selected', variantId: $variant->id);
        }

        return $variant;
    }

    protected function getVariantAttributes(): array
    {
        if ($this->productOptions->isNotEmpty()) {
            return $this->variant->values->mapWithKeys(fn ($value): array => [
                $value->attribute->name => $value->value,
            ])->toArray();
        }

        return [
            'Variant' => $this->variant?->name,
        ];
    }

    public function render(): View
    {
        return view('livewire.components.variants-selector');
    }
}
