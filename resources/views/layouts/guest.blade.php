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
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-black">
            <!-- Logo -->
            <div class="mb-8">
                <a href="/" class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-[#1d9bf0] rounded-lg flex items-center justify-center">
                        <span class="text-white text-2xl font-bold">L</span>
                    </div>
                    <span class="text-2xl font-bold bg-gradient-to-r from-[#1d9bf0] to-[#1a8cd8] bg-clip-text text-transparent">
                        LinkUp
                    </span>
                </a>
            </div>

            <!-- Auth Card -->
            <div class="w-full sm:max-w-md px-6 py-8 bg-[#000] border border-[#2f3336] shadow-lg sm:rounded-2xl">
                {{ $slot }}
            </div>

            <!-- Footer Links -->
            <div class="mt-8 text-center text-[#71767b] text-sm">
                <div class="flex flex-wrap justify-center gap-4 mb-3">
                    <a href="#" class="hover:text-[#e7e9ea] transition-colors">About</a>
                    <a href="#" class="hover:text-[#e7e9ea] transition-colors">Help Center</a>
                    <a href="#" class="hover:text-[#e7e9ea] transition-colors">Terms of Service</a>
                    <a href="#" class="hover:text-[#e7e9ea] transition-colors">Privacy Policy</a>
                    <a href="#" class="hover:text-[#e7e9ea] transition-colors">Cookie Policy</a>
                </div>
                <p class="text-xs">© 2024 LinkUp Corp.</p>
            </div>
        </div>
    </body>
</html>