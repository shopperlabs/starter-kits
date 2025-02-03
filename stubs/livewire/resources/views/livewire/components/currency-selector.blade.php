<?php

declare(strict_types=1);

use App\Actions\ZoneSessionManager;
use Livewire\Volt\Component;
use Livewire\Attributes\Computed;
use Shopper\Core\Models\Country;

new class extends Component {
    #[Computed(persist: true)]
    public function countryFlag(): string|null
    {
        return session('zone')
            ? ZoneSessionManager::getSession()->countryFlag
            : (
            shopper_setting('country_id')
                ? Country::query()->find(shopper_setting('country_id'))->svg_flag
                : null
            );
    }
} ?>

<div class="hidden lg:ml-8 lg:flex">
    <button
        @if(session('zone'))
            onclick="Livewire.dispatch('openPanel', { component: 'modals.zone-selector' })"
        @endif
        type="button"
        @class([
            'flex items-center gap-2 text-gray-700 hover:text-gray-800',
            'cursor-default' => ! session()->has('zone')
        ])
    >
        @if($this->countryFlag)
            <img src="{{ $this->countryFlag }}" alt="country flag" class="block h-auto w-5 shrink-0" />
        @endif

        <span class="block text-sm font-medium">{{ current_currency() }}</span>
        <span class="sr-only">, {{ __('change currency') }}</span>
    </button>
</div>
