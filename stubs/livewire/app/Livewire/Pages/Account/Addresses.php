<?php

declare(strict_types=1);

namespace App\Livewire\Pages\Account;

use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Shopper\Core\Models\Address;

#[Layout('components.layouts.templates.account')]
class Addresses extends Component
{
    public function removeAddress(int $id): void
    {
        Address::query()->find($id)->delete();

        Notification::make()
            ->title(__('The address has been correctly removed from your list!'))
            ->success()
            ->send();

        $this->dispatch('addresses-updated');
    }

    #[On('addresses-updated')]
    public function render(): View
    {
        return view('livewire.pages.account.addresses', [
            'addresses' => auth()->user()->addresses->load('country'),
        ])
            ->title(__('My addresses'));
    }
}
