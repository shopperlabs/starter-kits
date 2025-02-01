<?php

declare(strict_types=1);

use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.templates.account')] class extends Component {
    #[Computed(persist: true)]
    public function links(): array
    {
        return [
            [
                'title' => __('My orders'),
                'description' => __('Track your orders, return them or buy them again'),
                'href' => route('account.orders'),
                'icon' => 'untitledui-shopping-bag-03'
            ],
            [
                'title' => __('Personal information'),
                'description' => __('Change of e-mail address, name and telephone number'),
                'href' => route('account.profile'),
                'icon' => 'untitledui-shield-tick'
            ],
            [
                'title' => __('My addresses'),
                'description' => __('Billing and delivery preferences for orders'),
                'href' => route('account.addresses'),
                'icon' => 'untitledui-globe-05'
            ],
            [
                'title' => __('Contact us'),
                'description' => __('Contact our customer service department by telephone or e-mail'),
                'href' => route('account'),
                'icon' => 'untitledui-phone'
            ],
        ];
    }
}; ?>

<div class="space-y-10">
    <x-page-heading
        :title="__('Overview')"
        :description="__('In your customer area, you can manage your orders and returns, as well as your personal information.')"
    />

    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:max-w-5xl lg:grid-cols-3">
        @foreach($this->links as $link)
            <x-account-card-link
                :href="$link['href']"
                :title="$link['title']"
                :description="$link['description']"
                :icon="$link['icon']"
            />
        @endforeach
    </div>
</div>
