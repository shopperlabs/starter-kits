@props([
    'title' => null,
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <x-shopper::favicons />

    <title>{{ $title ?? 'Starter Kit by Shopper' }} // {{ config('app.name') }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    @filamentStyles
    @vite('resources/css/app.css')
</head>
<body class="antialiased selection:bg-primary-600 selection:text-white">
    {{ $slot }}

    <x-shopper::adminbar />

    @livewire('notifications')
    @livewire('slide-over-panel')
    @livewire('wire-elements-modal')

    @filamentScripts
    @vite('resources/js/app.js')
</body>
</html>
