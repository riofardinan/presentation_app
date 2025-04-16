<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="{{ asset('logo.png') }}" type="image/png">

    <title>@yield('title', 'My App')</title>
    
    {{-- Tailwind --}}
    @vite('resources/css/app.css')
    @stack('styles')
</head>

<body class="{{ Request::is('tutorials') ? 'bg-sky-50' : '' }}">
    @yield('content')

    @vite(['resources/js/app.js'])

    @stack('scripts')
</body>

</html>
