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
