<?php

declare(strict_types=1);

namespace App\Livewire\Pages;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Livewire\Component;

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
                ->publish()
                ->get(),
        ]);
    }
}
