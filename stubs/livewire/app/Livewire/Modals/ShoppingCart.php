<?php

declare(strict_types=1);

namespace App\Livewire\Modals;

use Darryldecode\Cart\CartCollection;
use Darryldecode\Cart\Facades\CartFacade;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Laravelcm\LivewireSlideOvers\SlideOverComponent;

class ShoppingCart extends SlideOverComponent
{
    public float $subtotal = 0;

    public CartCollection $items;

    public ?string $sessionKey = null;

    public static function panelMaxWidth(): string
    {
        return 'lg';
    }

    public function mount(): void
    {
        $sessionKey = session()->getId();

        $this->sessionKey = $sessionKey;
        $this->items = CartFacade::session($sessionKey)->getContent();
        $this->subtotal = CartFacade::session($sessionKey)->getSubTotal();
    }

    public function cartUpdated(): void
    {
        $this->items = CartFacade::session($this->sessionKey)->getContent();
        $this->subtotal = CartFacade::session($this->sessionKey)->getSubTotal();
    }

    public function removeToCart(int $id): void
    {
        CartFacade::session($this->sessionKey)->remove($id);

        Notification::make()
            ->title(__('Cart updated'))
            ->body(__('The product  has been removed from your cart !'))
            ->success()
            ->send();

        $this->dispatch('cartUpdated');
        $this->dispatch('closePanel');
    }

    public function render(): View
    {
        return view('livewire.modals.shopping-cart');
    }
}
