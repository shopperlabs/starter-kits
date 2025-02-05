<?php

declare(strict_types=1);

namespace App\Livewire\Pages;

use App\Models\Collection;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.templates.app')]
class Home extends Component
{
    public function render(): View
    {
        return view('livewire.pages.home', [
            'products' => Product::with([
                'brand',
                'media',
                'prices' => function ($query) {
                    $query->whereRelation('currency', 'code', current_currency());
                },
                'prices.currency',
            ])
                ->withCount('variants')
                ->publish()
                ->get(),
            'collections' => Collection::with(['media'])
                ->select('id', 'slug', 'name')
                ->scopes('manual')
                ->take(3)
                ->get(),
        ]);
    }
}
