<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.templates.app')] class extends Component
{
    public string $first_name = '';
    public string $last_name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="relative">
    <svg
        class="absolute inset-0 -z-10 h-full w-full stroke-gray-100 [mask-image:radial-gradient(100%_100%_at_top_right,white,transparent)]"
        aria-hidden="true"
    >
        <defs>
            <pattern
                id="0787a7c5-978c-4f66-83c7-11c213f99cb7"
                width="200"
                height="200"
                x="50%"
                y="-1"
                patternUnits="userSpaceOnUse"
            >
                <path d="M.5 200V.5H200" fill="none" />
            </pattern>
        </defs>
        <rect width="100%" height="100%" stroke-width="0" fill="url(#0787a7c5-978c-4f66-83c7-11c213f99cb7)" />
    </svg>

    <div class="relative min-h-full flex flex-col justify-center py-12 divide-y divide-gray-200 lg:max-w-2xl lg:mx-auto">
        <div class="sm:mx-auto sm:w-full sm:max-w-md py-8">
            <h2 class="text-2xl font-medium text-gray-900 font-heading">
                {{ __("Création de compte") }}
            </h2>
            <div class="mt-6 space-y-6">
                <form wire:submit="register" class="space-y-4">
                    <!-- Last Name -->
                    <div>
                        <x-forms.label for="name" :value="__('Nom')" />
                        <x-forms.input wire:model="last_name" id="last_name" class="block mt-1 w-full" type="text" name="last_name" required autofocus autocomplete="last_name" />
                        <x-forms.errors :messages="$errors->get('last_name')" class="mt-2" />
                    </div>

                    <!-- First Name -->
                    <div>
                        <x-forms.label for="name" :value="__('Prénom')" />
                        <x-forms.input wire:model="first_name" id="first_name" class="block mt-1 w-full" type="text" name="first_name" required autocomplete="first_name" />
                        <x-forms.errors :messages="$errors->get('first_name')" class="mt-2" />
                    </div>

                    <!-- Email Address -->
                    <div class="mt-4">
                        <x-forms.label for="email" :value="__('Adresse e-mail')" />
                        <x-forms.input wire:model="email" id="email" class="block mt-1 w-full" type="email" name="email" required autocomplete="username" />
                        <x-forms.errors :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <x-forms.label for="password" :value="__('Mot de passe')" />

                        <x-forms.input wire:model="password" id="password" class="block mt-1 w-full"
                                       type="password"
                                       name="password"
                                       required autocomplete="new-password" />

                        <x-forms.errors :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="mt-4">
                        <x-forms.label for="password_confirmation" :value="__('Confirmer mot de passe')" />

                        <x-forms.input wire:model="password_confirmation" id="password_confirmation" class="block mt-1 w-full"
                                       type="password"
                                       name="password_confirmation" required autocomplete="new-password" />

                        <x-forms.errors :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div class="space-y-2">
                        <x-link
                            class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            :href="route('login')"
                        >
                            {{ __('Vous avez déjà un compte?') }}
                        </x-link>

                        <x-buttons.submit :title="__('Create account')" wire:loading.attr="data-loading" class="w-full px-4 text-base" />
                    </div>
                </form>

                <x-auth-oauth />

                <p class="text-base text-center leading-6 text-gray-500">
                    En vous enregistrant pour créer un compte, vous acceptez nos
                    <x-link href="#" class="font-medium text-black group group-link-underline">
                        <span class="link link-underline link-underline-black">conditions générales</span>
                    </x-link>.
                    Veuillez lire notre
                    <x-link href="#" class="font-medium text-black group group-link-underline">
                        <span class="link link-underline link-underline-brand">politique de confidentialité</span>
                    </x-link>.
                </p>
            </div>
        </div>
    </div>
</div>
