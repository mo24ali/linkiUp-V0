<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="LinkUp - Where connections feel alive.">
    <title>LinkUp / Connect. Share. Discover.</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800&display=swap" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #000;
            color: #e7e9ea;
            overflow-x: hidden;
        }

        .gradient-text {
            background: linear-gradient(135deg, #1d9bf0 0%, #00ba7c 50%, #f91880 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-image {
            background-image: url("{{ asset('storage/social_network_hero_1770125540719.png') }}");
            background-size: cover;
            background-position: center;
        }

        /* Fallback if image not found in storage yet */
        .hero-image-fallback {
            background: radial-gradient(circle at center, #1d9bf01a 0%, #000 70%);
        }
    </style>
</head>

<body class="antialiased">
    <div class="flex flex-col lg:flex-row min-h-screen">
        <!-- Image Side (Hidden on Mobile) -->
        <div
            class="hidden lg:flex lg:w-1/2 relative hero-image items-center justify-center p-12 overflow-hidden border-r border-[#2f3336]">
            <!-- Content overlay for image side -->
            <div class="absolute inset-0 bg-black/20 backdrop-blur-[2px]"></div>

            <div class="relative z-10 text-center space-y-6">
                <div
                    class="w-24 h-24 bg-white/10 backdrop-blur-xl rounded-3xl flex items-center justify-center mx-auto border border-white/20 shadow-2xl">
                    <span class="text-white text-5xl font-black italic tracking-tighter">L</span>
                </div>
                <h2 class="text-4xl font-extrabold text-white tracking-tight leading-tight">
                    Beyond the Scroll.<br>
                    <span class="text-[#1d9bf0]">Real Connections.</span>
                </h2>
            </div>
        </div>

        <!-- content Side -->
        <div class="flex-1 flex flex-col justify-center p-6 sm:p-12 lg:p-20 relative overflow-hidden">
            <!-- Background mesh -->
            <div
                class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/2 w-[500px] h-[500px] bg-blue-500/10 blur-[120px] rounded-full">
            </div>
            <div
                class="absolute bottom-0 left-0 translate-y-1/2 -translate-x-1/2 w-[500px] h-[500px] bg-pink-500/10 blur-[120px] rounded-full">
            </div>

            <div class="relative z-10 max-w-lg mx-auto lg:mx-0">
                <!-- Mobile Logo -->
                <div class="lg:hidden mb-12">
                    <div class="w-12 h-12 bg-[#1d9bf0] rounded-xl flex items-center justify-center">
                        <span class="text-white text-2xl font-black italic">L</span>
                    </div>
                </div>

                <h1 class="text-5xl sm:text-7xl font-black tracking-tighter mb-8 leading-[0.9]">
                    Happening <br>
                    <span class="gradient-text">Now.</span>
                </h1>

                <p class="text-xl sm:text-2xl font-semibold mb-12 text-[#e7e9ea] tracking-tight">
                    Join LinkUp today and discover a new way to connect with your world.
                </p>

                <div class="space-y-6">
                    <h3 class="text-xl font-extrabold">Join the community.</h3>

                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn-vibrant w-full block text-center py-4 text-lg">
                                Return to Dashboard
                            </a>
                        @else
                            <div class="space-y-4">
                                <a href="{{ route('register') }}" class="btn-vibrant w-full block text-center py-4 text-lg">
                                    Create account
                                </a>
                                <p class="text-[11px] text-[#71767b] leading-relaxed">
                                    By signing up, you agree to the <a href="#" class="text-[#1d9bf0] hover:underline">Terms of
                                        Service</a> and <a href="#" class="text-[#1d9bf0] hover:underline">Privacy Policy</a>,
                                    including <a href="#" class="text-[#1d9bf0] hover:underline">Cookie Use</a>.
                                </p>
                            </div>

                            <div class="pt-12 space-y-4">
                                <h4 class="font-bold text-lg">Already have an account?</h4>
                                <a href="{{ route('login') }}"
                                    class="w-full block text-center py-4 text-lg border border-[#2f3336] rounded-full font-bold text-[#1d9bf0] hover:bg-[#1d9bf0]/10 transition-all">
                                    Sign in
                                </a>
                            </div>
                        @endauth
                    @endif
                </div>

                <!-- Footer Links -->
                <footer class="mt-20 flex flex-wrap gap-x-6 gap-y-2 text-xs text-[#71767b]">
                    <a href="#" class="hover:underline">About</a>
                    <a href="#" class="hover:underline">Help Center</a>
                    <a href="#" class="hover:underline">Terms of Service</a>
                    <a href="#" class="hover:underline">Privacy Policy</a>
                    <a href="#" class="hover:underline">Cookie Policy</a>
                    <a href="#" class="hover:underline">Accessibility</a>
                    <a href="#" class="hover:underline">Ads info</a>
                    <a href="#" class="hover:underline">Blog</a>
                    <a href="#" class="hover:underline">Status</a>
                    <a href="#" class="hover:underline">Careers</a>
                    <a href="#" class="hover:underline">Brand Resources</a>
                    <a href="#" class="hover:underline">Adverting</a>
                    <a href="#" class="hover:underline">Marketing</a>
                    <p class="mt-4">© 2026 LinkUp Corp.</p>
                </footer>
            </div>
        </div>
    </div>
</body>

</html>