<div class="h-8 bg-primary-600 flex items-center justify-center">
    <p class="text-sm font-medium text-white sm:px-6 lg:px-8">
        {{ __('Free shipping from :amount', ['amount' => shopper_money_format(config('starterkit.free_shipping_amount'), current_currency())]) }}
    </p>
</div>
