<?php

declare(strict_types=1);

namespace App\Livewire\Pages;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

/**
 * @property-read ProductVariant $selectedVariant
 */
#[Layout('components.layouts.templates.app')]
class SingleProduct extends Component
{
    public ?Product $product = null;

    public function mount(string $slug): void
    {
        $product = Product::with([
            'media',
            'prices' => function ($query): void {
                $query->whereRelation('currency', 'code', current_currency());
            },
            'prices.currency',
            'inventoryHistories',
            'categories' => function ($query): void {
                $query->select('id', 'name');
            }
        ])
            ->withCount('variants')
            ->where('slug', $slug)
            ->firstOrFail();

        abort_unless($product->isPublished(), 404);

        $this->product = $product;
    }

    public function render(): View
    {
        return view('livewire.pages.single-product')
            ->title($this->product->name);
    }
}
