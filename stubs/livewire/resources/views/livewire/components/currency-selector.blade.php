<?php

declare(strict_types=1);

use Livewire\Volt\Component;
use Livewire\Attributes\Lazy;

new #[Lazy] class extends Component {
    public function placeholder(): string
    {
        return <<<Blade
            <div class="flex items-center gap-1">
                <x-shopper::skeleton class="size-4 rounded-none" />
                <x-shopper::skeleton class="w-6 h-2  rounded-none" />
            </div>
        Blade;
    }
} ?>

<div class="hidden lg:ml-8 lg:flex">
    <button
        onclick="Livewire.dispatch('openPanel', { component: 'modals.zone-selector' })"
        type="button"
        class="flex items-center text-gray-700 hover:text-gray-800"
    >
        <img src="{{ \App\Actions\ZoneSessionManager::getSession()?->countryFlag }}" alt="country flag" class="block h-auto w-5 shrink-0" />
        <span class="ml-2 block text-sm font-medium">{{ current_currency() }}</span>
        <span class="sr-only">, {{ __('changer la devise') }}</span>
    </button>
</div>
