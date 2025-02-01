<div class="mt-12 flex items-center">
    <p class="text-gray-500 text-sm leading-5">
        {{ __('Shipping to') }} :
    </p>
    <button
        onclick="Livewire.dispatch('openPanel', { component: 'modals.zone-selector' })"
        type="button"
        class="group font-semibold ml-4 flex items-center text-gray-900 hover:underline"
    >
        <img
            src="{{ \App\Actions\ZoneSessionManager::getSession()?->countryFlag }}"
            alt="country flag"
            class="block h-auto w-5 shrink-0"
        />
        <span class="ml-2 block text-sm font-medium">
            {{ \App\Actions\ZoneSessionManager::getSession()?->countryName }}
        </span>
        <span class="sr-only">, {{ __('change zone') }}</span>
    </button>
</div>
