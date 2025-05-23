<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body>
    @include('layouts.navigation')

    <main>
        {{ $slot }}
    </main>

    @livewireScripts
</body>
</html>
