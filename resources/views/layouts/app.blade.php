<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>LinkUp / {{ config('app.name', 'Social Network') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-black text-[#e7e9ea]">
    <div class="min-h-screen">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-black border-b border-[#2f3336] sticky top-0 z-10 backdrop-blur-sm bg-black/95">
                <div class="max-w-7xl mx-auto px-4 py-3">
                    <h1 class="text-xl font-bold">{{ $header }}</h1>
                </div>
            </header>
        @endisset
        @livewireStyles
        @livewireScripts

        <!-- Page Content -->
        <main class="max-w-7xl mx-auto px-4 py-6">
            {{ $slot }}
        </main>
    </div>
</body>

</html>