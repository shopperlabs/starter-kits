@props([
    'option',
])

<!-- Size picker -->
<div>
    <div class="flex items-center justify-between">
        <h2 class="text-sm font-medium text-gray-900">{{ $option->attribute->name }}</h2>
        <button type="button" class="text-sm font-medium text-primary-600 hover:text-primary-500">
            {{ __('Size guide') }}
        </button>
    </div>

    <fieldset class="mt-2">
        <legend class="sr-only">{{ __('Choose a size') }}</legend>
        <div
            class="grid grid-cols-3 gap-3 sm:grid-cols-6"
            x-data="{
                selectedOption: @entangle('selectedOptionValues').live,
                selectedValues: [],
            }"
            x-init="
                selectedValues = Object.values(selectedOption);
                $watch('selectedOption', value => selectedValues = Object.values(selectedOption))
            "
        >
            @foreach ($option->values as $value)
                <button
                    type="button"
                    class="flex cursor-pointer items-center justify-center border p-3 text-sm font-medium uppercase focus:outline-none sm:flex-1"
                    wire:click="$set('selectedOptionValues.{{ $option->attribute->id }}', {{ $value->id }})"
                    x-bind:class="{
                        'ring-2 ring-primary-600 ring-offset-2': selectedValues.includes({{ $value->id }}),
                        'border-transparent bg-primary-600 text-white hover:bg-primary-500': selectedValues.includes({{ $value->id }}),
                        'border-gray-200 bg-white text-gray-900 hover:bg-gray-50': !selectedValues.includes({{ $value->id }})
                    }"
                >
                    <span id="size-choice-{{ $value->id }}-label">{{ $value->value }}</span>
                </button>
            @endforeach
        </div>
    </fieldset>
</div>
