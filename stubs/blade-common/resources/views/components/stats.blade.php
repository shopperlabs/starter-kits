<x-container class="py-10 sm:py-14 lg:py-16">
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
        <div class="flex items-center">
            <x-phosphor-truck-duotone class="size-8 text-primary-500" aria-hidden="true" stroke-width="1.5" />
            <div class="ml-4">
                <h4 class="font-heading font-medium text-gray-900">{{ __('Free shipping') }}</h4>
                <p class="text-sm leading-5 text-gray-500">
                    {{ __('From :amount', ['amount' => shopper_money_format(5000, current_currency())]) }}
                </p>
            </div>
        </div>
        <div class="flex items-center">
            <x-phosphor-headset-duotone class="size-8 text-primary-500" aria-hidden="true" stroke-width="1.5" />
            <div class="ml-4">
                <h4 class="font-heading font-medium text-gray-900">{{ __('24/7 customer support') }}</h4>
                <p class="text-sm leading-5 text-gray-500">{{ __('Friendly 24/7 customer support') }}</p>
            </div>
        </div>
        <div class="flex items-center">
            <x-phosphor-shield-check-duotone class="size-8 text-primary-500" aria-hidden="true" stroke-width="1.5" />
            <div class="ml-4">
                <h4 class="font-heading font-medium text-gray-900">{{ __('Secure payment') }}</h4>
                <p class="text-sm leading-5 text-gray-500">{{ __('On all orders') }}</p>
            </div>
        </div>
        <div class="flex items-center">
            <x-phosphor-arrows-clockwise-duotone class="size-8 text-primary-500" aria-hidden="true" stroke-width="1.5" />
            <div class="ml-4">
                <h4 class="font-heading font-medium text-gray-900">{{ __('Return when you\'re ready') }}</h4>
                <p class="text-sm leading-5 text-gray-500">{{ __('60 days of free returns') }}</p>
            </div>
        </div>
    </div>
</x-container>
