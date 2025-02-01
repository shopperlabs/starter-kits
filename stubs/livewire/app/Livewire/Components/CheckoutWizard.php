<?php

declare(strict_types=1);

namespace App\Livewire\Components;

use App\Livewire\Components\Checkout\Delivery;
use App\Livewire\Components\Checkout\Payment;
use App\Livewire\Components\Checkout\Shipping;
use Spatie\LivewireWizard\Components\WizardComponent;

class CheckoutWizard extends WizardComponent
{
    /**
     * @return string[]
     */
    public function steps(): array
    {
        return [
            Shipping::class,
            Delivery::class,
            Payment::class,
        ];
    }
}
