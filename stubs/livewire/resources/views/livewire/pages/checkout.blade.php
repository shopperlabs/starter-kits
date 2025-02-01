<div class="bg-white">
    <!-- Background color split screen for large screens -->
    <div class="fixed left-0 top-0 hidden h-full w-1/2 bg-white lg:block" aria-hidden="true"></div>
    <div class="fixed right-0 top-0 hidden h-full w-1/2 bg-primary-800 lg:block" aria-hidden="true"></div>

    <header class="relative border-b border-gray-200 bg-white text-sm font-medium text-gray-700">
        <x-container class="py-4">
            <div class="relative flex items-center gap-10">
                <x-link :href="route('home')">
                    <span class="sr-only">{{ shopper_setting('legal_name') }}</span>
                    <x-brand class="h-10 w-auto" aria-hidden="true" />
                </x-link>
                <x-link :href="route('home')" class="inline-flex items-center font-medium text-gray-600 hover:text-gray-900">
                    {{ __('Back to store') }}
                </x-link>
            </div>
        </x-container>
    </header>

    <x-container class="relative grid grid-cols-1 gap-x-16 lg:grid-cols-2 xl:gap-x-48">
        <h1 class="sr-only">{{ __('Order information') }}</h1>

        <section
            aria-labelledby="summary-heading"
            class="bg-primary-950 px-4 pb-10 pt-16 sm:px-6 lg:col-start-2 lg:row-start-1 lg:bg-transparent lg:px-0 lg:pb-16"
        >
            <div class="mx-auto max-w-lg lg:max-w-none">
                <h2 id="summary-heading" class="text-lg font-medium text-white">
                    {{ __('Cart summary') }}
                </h2>

                <ul role="list" class="divide-y divide-white/10 text-sm font-medium text-white">
                    @foreach($items as $item)
                        <x-cart.element :item="$item" />
                    @endforeach
                </ul>

                <dl class="hidden space-y-6 border-t border-white/10 pt-6 text-sm font-medium text-white lg:block">
                    <div class="flex items-center justify-between">
                        <dt class="text-gray-300">{{ __('Sub total') }}</dt>
                        <dd>
                            {{ shopper_money_format(amount: $subtotal, currency: current_currency()) }}
                        </dd>
                    </div>

                    <div class="flex items-center justify-between">
                        <dt class="text-gray-300">{{ __('Shipping') }}</dt>
                        <livewire:components.shipping-price />
                    </div>

                    <div class="flex items-center justify-between">
                        <dt class="text-gray-300">{{ __('Taxes') }}</dt>
                        <livewire:components.tax-price />
                    </div>

                    <div class="flex items-center justify-between border-t border-white/10 pt-6">
                        <dt class="text-base">{{ __('Total') }}</dt>
                        <livewire:components.cart-total />
                    </div>
                </dl>

                <div class="lg:hidden">
                    <div
                        x-data="{ open: false }"
                        @keydown.escape="open = false"
                        class="fixed inset-x-0 bottom-0 flex flex-col-reverse text-sm font-medium text-white lg:hidden"
                    >
                        <div class="relative z-10 border-t border-white/10 bg-white px-4 sm:px-6">
                            <div class="mx-auto max-w-lg">
                                <button
                                    type="button"
                                    class="flex w-full items-center py-6 font-medium"
                                    aria-expanded="false"
                                    @click="open = !open"
                                >
                                    <span class="mr-auto text-base">{{ __('Total') }}</span>
                                    <span class="mr-2 text-base">
                                        <livewire:components.cart-total />
                                    </span>
                                    <svg
                                        class="size-5 text-gray-500"
                                        viewBox="0 0 20 20"
                                        fill="currentColor"
                                        aria-hidden="true"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M14.77 12.79a.75.75 0 01-1.06-.02L10 8.832 6.29 12.77a.75.75 0 11-1.08-1.04l4.25-4.5a.75.75 0 011.08 0l4.25 4.5a.75.75 0 01-.02 1.06z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div>
                            <div
                                x-show="open"
                                x-transition:enter="transition-opacity duration-300 ease-linear"
                                x-transition:enter-start="opacity-0"
                                x-transition:enter-end="opacity-100"
                                x-transition:leave="transition-opacity duration-300 ease-linear"
                                x-transition:leave-start="opacity-100"
                                x-transition:leave-end="opacity-0"
                                class="fixed inset-0 bg-black bg-opacity-25"
                                @click="open = !open"
                                aria-hidden="true"
                                style="display: none"
                            ></div>

                            <div
                                x-show="open"
                                x-transition:enter="transform transition duration-300 ease-in-out"
                                x-transition:enter-start="translate-y-full"
                                x-transition:enter-end="translate-y-0"
                                x-transition:leave="transform transition duration-300 ease-in-out"
                                x-transition:leave-start="translate-y-0"
                                x-transition:leave-end="translate-y-full"
                                class="relative bg-white px-4 py-6 sm:px-6"
                                x-ref="panel"
                                @click.away="open = false"
                                style="display: none"
                            >
                                <dl class="mx-auto max-w-lg space-y-6">
                                    <div class="flex items-center justify-between">
                                        <dt class="text-gray-400">{{ __('Sub total') }}</dt>
                                        <dd>
                                            {{ shopper_money_format(amount: $subtotal, currency: current_currency()) }}
                                        </dd>
                                    </div>

                                    <div class="flex items-center justify-between">
                                        <dt class="text-gray-400">{{ __('Shipping') }}</dt>
                                        <livewire:components.shipping-price />
                                    </div>

                                    <div class="flex items-center justify-between">
                                        <dt class="text-gray-400">{{ __('Taxes') }}</dt>
                                        <livewire:components.tax-price />
                                    </div>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="px-4 pb-36 pt-16 sm:px-6 lg:col-start-1 lg:row-start-1 lg:px-0 lg:pb-16">
            <livewire:components.checkout-wizard />
        </div>
    </x-container>
</div>
