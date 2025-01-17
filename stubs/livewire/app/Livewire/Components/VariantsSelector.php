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
use Livewire\Attributes\Computed;
use Livewire\Component;

/**
 * @property-read Collection $productOptionValues
 * @property-read Collection $productOptions
 * @property-read ProductVariant | null $variant
 */
class VariantsSelector extends Component
{
    public Product $product;

    public array $selectedOptionValues = [];

    public function mount(): void
    {
        $this->product->load(
            'inventoryHistories',
            'variants',
            'variants.values',
            'variants.values.attribute',
            'variants.inventoryHistories',
        );

        $this->selectedOptionValues = $this->productOptions->mapWithKeys(function (OptionData $option): array {
            return [$option->attribute->id => $option->values->first()->id];
        })->toArray();

        $this->dispatch('variant.selected', $this->selectedOptionValues);
    }

    public function addToCart(): void
    {
        $model = $this->variant ?? $this->product;

        CartFacade::session(session()->getId())->add([
            'id' => $model->id,
            'name' => $this->product->name,
            'price' => $model->getPrice()->amount->amount,
            'quantity' => 1,
            'attributes' => $this->variant
                ? $this->variant->values->mapWithKeys(fn ($value) => [
                    $value->attribute->name => $value->value,
                ])->toArray()
                : [],
            'associatedModel' => $model,
        ]);

        Notification::make()
            ->title(__('Panier modifié'))
            ->body(__('Le produit a été ajouté au panier'))
            ->success()
            ->send();

        $this->dispatch('cartUpdated');
    }

    #[Computed]
    public function variant(): ?ProductVariant
    {
        return $this->product->variants->first(function ($variant) {
            return ! $variant->values->pluck('id')
                ->diff(collect($this->selectedOptionValues)->values())
                ->count();
        });
    }

    public function updatedSelectedOptionValues(): void
    {
        $this->dispatch('variant.selected', values: $this->selectedOptionValues);
    }

    #[Computed]
    public function productOptionValues(): Collection
    {
        return $this->product->variants->pluck('values')->flatten();
    }

    #[Computed]
    public function productOptions(): Collection
    {
        return $this->productOptionValues->unique('id')->groupBy('attribute_id')
            ->map(function ($values) {
                return new OptionData(
                    attribute: $values->first()->attribute,
                    values: $values,
                );
            })->values();
    }

    public function render(): View
    {
        return view('livewire.components.variants-selector');
    }
}
