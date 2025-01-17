@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'inline-flex w-full py-2 placeholder-gray-500 border-gray-300 focus:ring-brand focus:ring-2 focus:border-transparent border-gray-300 focus:outline-none sm:text-sm']) !!}>
