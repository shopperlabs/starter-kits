<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.templates.app')] class extends Component
{
    public string $email = '';

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $this->only('email')
        );

        if ($status != Password::RESET_LINK_SENT) {
            $this->addError('email', __($status));

            return;
        }

        $this->reset('email');

        session()->flash('status', __($status));
    }
}; ?>

<div class="min-h-full flex flex-col justify-center py-12 divide-y divide-gray-200 lg:max-w-2xl lg:mx-auto">
    <div class="sm:mx-auto sm:w-full sm:max-w-md py-8">
        <div class="space-y-2">
            <h2 class="text-2xl font-medium text-gray-900 font-heading">
                {{ __('Récupérez Votre mot de Passe') }}
            </h2>
            <p class="text-sm leading-5 text-gray-500">
                {{ __("Veuillez saisir votre adresse e-mail pour réinitialiser votre mot de passe. Contactez le Service Clients pour plus d’assistance.") }}
            </p>
        </div>

        <div class="mt-6 space-y-4">
            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form wire:submit="sendPasswordResetLink">
                <!-- Email Address -->
                <div>
                    <x-forms.label for="email" :value="__('Email')" />
                    <x-forms.input wire:model="email" id="email" class="block mt-1 w-full" type="email" name="email" required autofocus />
                    <x-forms.errors :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-buttons.submit :title="__('Reset link')" wire:loading.attr="data-loading" />
                </div>
            </form>
        </div>
    </div>
</div>
