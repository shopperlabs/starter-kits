<div class="flex flex-col justify-between space-y-10">
    @include('components.checkout-steps')

    <form wire:submit="save" class="flex-1 space-y-3">
        @error('currentSelected')
        <div class="p-4 border-l-4 border-red-400 bg-red-50">
            <div class="flex">
                <div class="shrink-0">
                    <svg class="size-5 text-red-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-red-700">
                        {{ __($message) }}
                    </p>
                </div>
            </div>
        </div>
        @enderror

        <div class="max-w-lg mx-auto lg:max-w-none">
            <fieldset aria-label="{{ __('Payment method') }}">
                <div class="-space-y-px bg-white">
                    @foreach($methods as $method)
                        <label
                            aria-label="{{ $method->name }}"
                            @class([
                                'group relative flex items-center justify-between cursor-pointer border p-4 focus:outline-none',
                                'data-[checked]:z-10 data-[checked]:border-green-200 data-[checked]:bg-green-50 z-10 border-primary-200 bg-primary-50' => $currentSelected === $method->id,
                                'border-gray-200' => $currentSelected !== $method->id,
                            ])
                        >
                            <span class="flex flex-1">
                                <input
                                    type="radio"
                                    wire:model.live.debounce="currentSelected"
                                    name="shipping"
                                    value="{{ $method->id }}"
                                    class="mt-0.5 size-4 shrink-0 cursor-pointer border-gray-300 text-primary-500 focus:ring-primary-600 active:ring-2 active:ring-offset-2"
                                >
                                <span class="flex flex-col ml-3">
                                    <span
                                        @class([
                                            'block text-sm font-heading',
                                            'text-primary-950 font-medium' => $currentSelected === $method->id,
                                            'text-gray-600' => $currentSelected !== $method->id,
                                        ])
                                    >{{ $method->title }}</span>
                                </span>
                            </span>
                            <x-dynamic-component :component="'icons.payments.' . $method->slug" class="text-gray-500" />
                        </label>
                    @endforeach
                </div>
            </fieldset>

            <div class="mt-8 space-y-8">
                <p class="text-sm leading-5 text-gray-500">
                    {{ __(" By clicking on the 'Place my order' button, you confirm that you have read,
                     understood and accepted our terms of use, our terms of sale and our returns policy,
                      and you acknowledge that you have read our privacy policy.") }}
                </p>
                <div class="pt-6 border-t border-gray-200 sm:flex sm:items-center sm:justify-end">
                    <x-buttons.primary type="submit" class="w-full px-8 py-2 text-sm sm:w-auto">
                        <span class="absolute left-0 pl-2" wire:loading>
                            <x-loading-dots class="bg-white" aria-hidden="true" />
                        </span>
                        {{ __('Place my order') }}
                    </x-buttons.primary>
                </div>
            </div>
        </div>
    </form>
</div>
