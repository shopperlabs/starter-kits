<header class="sticky top-0 z-20 border-b border-gray-200 bg-white bg-opacity-80 backdrop-blur-xl backdrop-filter">
    <x-banner />
    <x-container class="flex items-center justify-between px-4 py-2">
        <nav role="navigation" class="flex items-center gap-10">
            <x-link :href="route('home')" class="relative text-sm">
                <x-brand class="h-8 w-auto" aria-hidden="true" />
            </x-link>
            <livewire:components.navigation />
        </nav>
        <div class="ml-auto flex items-center">
            <div class="hidden lg:flex lg:flex-1 lg:items-center lg:justify-end lg:space-x-6">
                @auth
                    <livewire:components.account-menu />
                @else
                    <x-link :href="route('login')" class="text-sm font-medium text-gray-700 hover:text-gray-800">
                        {{ __('Login') }}
                    </x-link>
                    <span class="h-6 w-px bg-gray-200" aria-hidden="true"></span>
                    <x-link :href="route('register')" class="text-sm font-medium text-gray-700 hover:text-gray-800">
                        {{ __('Register') }}
                    </x-link>
                @endauth
            </div>

            <!-- Currency -->
            <livewire:components.currency-selector />

            <!-- Search -->
            <livewire:components.global-search />

            <!-- Cart -->
            <livewire:components.shopping-cart-button />
        </div>
    </x-container>
</header>
