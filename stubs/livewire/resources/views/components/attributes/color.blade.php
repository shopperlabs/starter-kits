@props([
    'option',
])

<!-- Color picker -->
<div>
    <h2 class="text-sm font-medium text-gray-900">{{ $option->attribute->name }}</h2>

    <fieldset class="mt-2">
        <legend class="sr-only">{{ __('Choose a color') }}</legend>
        <div
            class="flex items-center space-x-3"
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
                    class="relative -m-0.5 flex items-center justify-center p-0.5 focus:outline-none"
                    wire:click="$set('selectedOptionValues.{{ $option->attribute->id }}', {{ $value->id }})"
                    x-bind:class="{
                        'ring-2 ring-primary-600': selectedValues.includes({{ $value->id }}),
                        'border border-gray-200': !selectedValues.includes({{ $value->id }})
                    }"
                >
                    <span id="color-choice-{{ $value->id }}-label" class="sr-only">{{ $value->value }}</span>
                    <span
                        aria-hidden="true"
                        class="size-8"
                        style="background-color: {{ $value->key }}"
                    ></span>
                </button>
            @endforeach
        </div>
    </fieldset>
</div>
