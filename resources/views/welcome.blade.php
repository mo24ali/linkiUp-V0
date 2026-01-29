<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="LinkUp - See what's happening">

        <title>LinkUp / {{ config('app.name', 'Social Network') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                /*! tailwindcss v4.0.7 | MIT License | https://tailwindcss.com */
                /* Reduced to essential styles only */
                @layer theme {
                    :root,:host {
                        --font-sans: 'Inter', ui-sans-serif, system-ui, sans-serif;
                        --color-black: #000;
                        --color-white: #fff;
                        --color-gray-800: #1f2937;
                        --color-gray-900: #111827;
                        --spacing: .25rem;
                        --text-sm: .875rem;
                        --text-base: 1rem;
                        --text-lg: 1.125rem;
                        --text-xl: 1.25rem;
                        --text-2xl: 1.5rem;
                        --font-weight-bold: 700;
                        --font-weight-semibold: 600;
                        --radius-lg: .5rem;
                        --shadow-sm: 0 1px 3px 0 #0000001a;
                    }
                }
                
                @layer base {
                    *,:after,:before,::backdrop {
                        box-sizing: border-box;
                        margin: 0;
                        padding: 0;
                    }
                    
                    html,:host {
                        font-family: var(--font-sans);
                        -webkit-tap-highlight-color: transparent;
                    }
                    
                    body {
                        background-color: var(--color-black);
                        color: #e7e9ea;
                    }
                }
                
                @layer utilities {
                    .fixed { position: fixed; }
                    .sticky { position: sticky; }
                    .relative { position: relative; }
                    .flex { display: flex; }
                    .hidden { display: none; }
                    .block { display: block; }
                    .h-screen { height: 100vh; }
                    .min-h-screen { min-height: 100vh; }
                    .w-full { width: 100%; }
                    .max-w-2xl { max-width: 42rem; }
                    .flex-1 { flex: 1; }
                    .flex-col { flex-direction: column; }
                    .items-center { align-items: center; }
                    .justify-between { justify-content: space-between; }
                    .gap-3 { gap: calc(var(--spacing)*3); }
                    .rounded-full { border-radius: 9999px; }
                    .rounded-lg { border-radius: var(--radius-lg); }
                    .border { border-width: 1px; }
                    .bg-\[\#000\] { background-color: #000; }
                    .bg-\[\#1d9bf0\] { background-color: #1d9bf0; }
                    .bg-gray-900 { background-color: var(--color-gray-900); }
                    .p-3 { padding: calc(var(--spacing)*3); }
                    .p-4 { padding: calc(var(--spacing)*4); }
                    .px-4 { padding-left: calc(var(--spacing)*4); padding-right: calc(var(--spacing)*4); }
                    .py-2 { padding-top: calc(var(--spacing)*2); padding-bottom: calc(var(--spacing)*2); }
                    .py-3 { padding-top: calc(var(--spacing)*3); padding-bottom: calc(var(--spacing)*3); }
                    .text-center { text-align: center; }
                    .text-sm { font-size: var(--text-sm); }
                    .text-xl { font-size: var(--text-xl); }
                    .text-2xl { font-size: var(--text-2xl); }
                    .font-bold { font-weight: var(--font-weight-bold); }
                    .font-semibold { font-weight: var(--font-weight-semibold); }
                    .text-\[\#1d9bf0\] { color: #1d9bf0; }
                    .text-\[\#71767b\] { color: #71767b; }
                    .text-white { color: var(--color-white); }
                    .border-gray-800 { border-color: var(--color-gray-800); }
                    .hover\:bg-\[\#1a8cd8\]:hover { background-color: #1a8cd8; }
                    .hover\:bg-gray-900:hover { background-color: var(--color-gray-900); }
                    .transition-colors { transition-property: color, background-color, border-color; transition-duration: .2s; }
                    
                    @media (min-width: 768px) {
                        .md\:flex { display: flex; }
                        .md\:hidden { display: none; }
                        .md\:h-screen { height: 100vh; }
                        .md\:w-20 { width: 5rem; }
                        .md\:w-64 { width: 16rem; }
                        .md\:max-w-\[600px\] { max-width: 600px; }
                        .md\:border-r { border-right-width: 1px; }
                    }
                }
            </style>
        @endif
    </head>
    <body class="bg-[#000] text-[#e7e9ea] min-h-screen">
        <div class="md:flex md:h-screen max-w-7xl mx-auto">
            <!-- Left Sidebar -->
            <div class="fixed bottom-0 left-0 right-0 z-20 bg-[#000] border-t border-gray-800 
                        md:relative md:border-t-0 md:border-r md:border-gray-800 md:w-20 lg:w-64 
                        md:flex md:flex-col md:h-screen">
                <div class="flex justify-around md:flex-col md:items-center lg:items-start 
                           md:pt-6 md:px-2 lg:px-4 md:h-full">
                    <!-- Logo -->
                    <div class="p-3">
                        <a href="/" class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-[#1d9bf0] rounded-lg flex items-center justify-center">
                                <span class="text-white font-bold">L</span>
                            </div>
                            <span class="hidden lg:block text-xl font-bold">LinkUp</span>
                        </a>
                    </div>
                    
                    <!-- Navigation -->
                    <div class="flex md:flex-col gap-1 md:flex-1">
                        <a href="#" class="p-3 hover:bg-gray-900 rounded-full transition-colors duration-200 flex items-center gap-3">
                            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 1.696L.622 8.807l1.06 1.696L3 9.679v9.57C3 21.295 4.652 23 6.736 23h10.528C19.348 23 21 21.295 21 19.249v-9.57l1.318.824 1.06-1.696L12 1.696zM12 3.054l8 5v10.195c0 1.126-.956 2.041-2.136 2.041H6.136C4.956 20.29 4 19.375 4 18.249V8.054l8-5z"/>
                            </svg>
                            <span class="hidden lg:block">Home</span>
                        </a>
                        
                        <a href="#" class="p-3 hover:bg-gray-900 rounded-full transition-colors duration-200 flex items-center gap-3">
                            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M10.25 3.75c-3.59 0-6.5 2.91-6.5 6.5s2.91 6.5 6.5 6.5c1.795 0 3.419-.726 4.596-1.904l1.204 1.204h-3.8v-3.8l1.204 1.204c.65-.65 1.046-1.546 1.046-2.504 0-3.59-2.91-6.5-6.5-6.5z"/>
                            </svg>
                            <span class="hidden lg:block">Explore</span>
                        </a>
                        
                        <a href="#" class="p-3 hover:bg-gray-900 rounded-full transition-colors duration-200 flex items-center gap-3">
                            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M1.998 5.5c0-1.381 1.119-2.5 2.5-2.5h15c1.381 0 2.5 1.119 2.5 2.5v13c0 1.381-1.119 2.5-2.5 2.5h-15c-1.381 0-2.5-1.119-2.5-2.5v-13zm2.5-.5c-.276 0-.5.224-.5.5v2.764l8 3.638 8-3.636V5.5c0-.276-.224-.5-.5-.5h-15zm15.5 5.463l-8 3.636-8-3.638V18.5c0 .276.224.5.5.5h15c.276 0 .5-.224.5-.5v-8.037z"/>
                            </svg>
                            <span class="hidden lg:block">Messages</span>
                        </a>
                    </div>
                    
                    <!-- Bottom Section -->
                    <div class="mt-auto mb-4">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="p-3 hover:bg-gray-900 rounded-full transition-colors duration-200 flex items-center gap-3">
                                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/>
                                    </svg>
                                    <span class="hidden lg:block">Profile</span>
                                </a>
                            @else
                                <div class="p-3">
                                    <a href="{{ route('login') }}" class="bg-[#1d9bf0] text-white px-4 py-2 rounded-full font-semibold hover:bg-[#1a8cd8] transition-colors duration-200 text-sm block text-center">
                                        Sign In
                                    </a>
                                </div>
                            @endauth
                        @endif
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="flex-1 md:max-w-[600px] lg:max-w-2xl border-r border-gray-800 min-h-screen md:h-screen overflow-y-auto">
                <!-- Header -->
                <div class="sticky top-0 z-10 bg-[#000]/95 backdrop-blur-sm border-b border-gray-800 px-4 py-3">
                    <h1 class="text-xl font-bold">Home</h1>
                </div>

                <!-- Post Composer / Welcome -->
                <div class="p-4 border-b border-gray-800">
                    @if (Route::has('login'))
                        @auth
                            <div class="flex gap-3">
                                <div class="shrink-0">
                                    <div class="w-12 h-12 bg-gray-700 rounded-full"></div>
                                </div>
                                <div class="flex-1">
                                    <textarea 
                                        placeholder="What's happening?" 
                                        class="w-full bg-transparent text-xl placeholder:text-[#71767b] resize-none focus:outline-none min-h-[120px]"
                                        rows="3"
                                    ></textarea>
                                    <div class="flex justify-between items-center mt-4">
                                        <div class="flex gap-2 text-[#1d9bf0]">
                                            <button class="w-9 h-9 hover:bg-gray-900 rounded-full flex items-center justify-center">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M3 5.5C3 4.119 4.119 3 5.5 3h13C19.881 3 21 4.119 21 5.5v13c0 1.381-1.119 2.5-2.5 2.5h-13C4.119 21 3 19.881 3 18.5v-13zM5.5 5c-.276 0-.5.224-.5.5v9.086l3-3 3 3 5-5 3 3V5.5c0-.276-.224-.5-.5-.5h-13zM19 15.414l-3-3-5 5-3-3-3 3V18.5c0 .276.224.5.5.5h13c.276 0 .5-.224.5-.5v-3.086zM9.75 7.5a2.25 2.25 0 100 4.5 2.25 2.25 0 000-4.5z"/>
                                                </svg>
                                            </button>
                                        </div>
                                        <button class="bg-[#1d9bf0] text-white px-4 py-2 rounded-full font-semibold hover:bg-[#1a8cd8] transition-colors duration-200 text-sm">
                                            Post
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-8">
                                <h2 class="text-2xl font-bold mb-3">See what's happening</h2>
                                <p class="text-[#71767b] mb-6">Join LinkUp today.</p>
                                <div class="space-y-3 max-w-xs mx-auto">
                                    <a href="{{ route('register') }}" class="block w-full bg-[#1d9bf0] text-white py-3 rounded-full font-semibold hover:bg-[#1a8cd8] transition-colors duration-200">
                                        Create account
                                    </a>
                                    <p class="text-[#71767b] text-sm">By signing up, you agree to the Terms of Service and Privacy Policy.</p>
                                    <div class="pt-4">
                                        <p class="text-[#71767b] mb-3">Already have an account?</p>
                                        <a href="{{ route('login') }}" class="block w-full border border-gray-800 text-[#1d9bf0] py-3 rounded-full font-semibold hover:bg-gray-900 transition-colors duration-200">
                                            Sign in
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endauth
                    @endif
                </div>

                <!-- Feed -->
                <div>
                    <!-- Trending -->
                    <div class="p-4 border-b border-gray-800">
                        <h3 class="font-bold text-lg mb-3">Trending now</h3>
                        <div class="space-y-4">
                            <div class="hover:bg-gray-900 p-3 rounded-lg transition-colors duration-200 cursor-pointer">
                                <div class="text-[#71767b] text-sm">Trending</div>
                                <div class="font-bold">#LinkUpLaunch</div>
                                <div class="text-[#71767b] text-sm">10.2K posts</div>
                            </div>
                            <div class="hover:bg-gray-900 p-3 rounded-lg transition-colors duration-200 cursor-pointer">
                                <div class="text-[#71767b] text-sm">Technology · Trending</div>
                                <div class="font-bold">Social Networks</div>
                                <div class="text-[#71767b] text-sm">45.5K posts</div>
                            </div>
                        </div>
                    </div>

                    <!-- Posts -->
                    <div class="p-4 border-b border-gray-800 hover:bg-gray-900 transition-colors duration-200 cursor-pointer">
                        <div class="flex gap-3">
                            <div class="shrink-0">
                                <div class="w-12 h-12 bg-gray-700 rounded-full"></div>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="font-bold hover:text-[#1d9bf0]">John Smith</span>
                                    <span class="text-[#71767b]">@johnsmith · 2h</span>
                                </div>
                                <p class="mb-3">Just joined LinkUp! The minimalist design is exactly what I needed. Clean, fast, and straight to the point.</p>
                                <div class="flex justify-between text-[#71767b]">
                                    <button class="flex items-center gap-2 hover:text-[#1d9bf0]">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M1.751 10c0-4.42 3.584-8 8.005-8h4.366c4.49 0 8.129 3.64 8.129 8.13 0 2.96-1.607 5.68-4.196 7.11l-8.054 4.46v-3.69h-.067c-4.49.1-8.183-3.51-8.183-8.01zm8.005-6c-3.317 0-6.005 2.69-6.005 6 0 3.37 2.77 6.08 6.138 6.01l.351-.01h1.761v2.3l5.087-2.81c1.951-1.08 3.163-3.13 3.163-5.36 0-3.39-2.744-6.13-6.129-6.13H9.756z"/>
                                        </svg>
                                        <span>24</span>
                                    </button>
                                    <button class="flex items-center gap-2 hover:text-green-500">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M4.5 3.88l4.432 4.14-1.364 1.46L5.5 7.55V16c0 1.1.896 2 2 2H13v2H7.5c-2.209 0-4-1.79-4-4V7.55L1.432 9.48.068 8.02 4.5 3.88zM16.5 6H11V4h5.5c2.209 0 4 1.79 4 4v8.45l2.068-1.93 1.364 1.46-4.432 4.14-4.432-4.14 1.364-1.46 2.068 1.93V8c0-1.1-.896-2-2-2z"/>
                                        </svg>
                                        <span>8</span>
                                    </button>
                                    <button class="flex items-center gap-2 hover:text-red-500">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M16.697 5.5c-1.222-.06-2.679.51-3.89 2.16l-.805 1.09-.806-1.09C9.984 6.01 8.526 5.44 7.304 5.5c-1.243.07-2.349.78-2.91 1.91-.552 1.12-.633 2.78.479 4.82 1.074 1.97 3.257 4.27 7.129 6.61 3.87-2.34 6.052-4.64 7.126-6.61 1.111-2.04 1.03-3.7.477-4.82-.561-1.13-1.666-1.84-2.908-1.91zm4.187 7.69c-1.351 2.48-4.001 5.12-8.379 7.67l-.503.3-.504-.3c-4.379-2.55-7.029-5.19-8.382-7.67-1.36-2.5-1.41-4.86-.514-6.67.887-1.79 2.647-2.91 4.601-3.01 1.651-.09 3.368.56 4.798 2.01 1.429-1.45 3.146-2.1 4.796-2.01 1.954.1 3.714 1.22 4.601 3.01.896 1.81.846 4.17-.514 6.67z"/>
                                        </svg>
                                        <span>128</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Sidebar -->
            <div class="hidden lg:block lg:w-80 p-4 overflow-y-auto h-screen">
                <!-- Search -->
                <div class="mb-6">
                    <div class="relative">
                        <input 
                            type="text" 
                            placeholder="Search LinkUp"
                            class="w-full bg-gray-900 border border-gray-800 rounded-full py-3 pl-10 pr-4 text-sm placeholder:text-[#71767b] focus:outline-none focus:ring-2 focus:ring-[#1d9bf0]"
                        >
                        <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-[#71767b]">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M10.25 3.75c-3.59 0-6.5 2.91-6.5 6.5s2.91 6.5 6.5 6.5c1.795 0 3.419-.726 4.596-1.904l1.204 1.204h-3.8v-3.8l1.204 1.204c.65-.65 1.046-1.546 1.046-2.504 0-3.59-2.91-6.5-6.5-6.5z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Who to follow -->
                <div class="bg-gray-900 rounded-xl p-4 mb-6">
                    <h3 class="font-bold text-lg mb-3">Who to follow</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gray-700 rounded-full"></div>
                                <div>
                                    <div class="font-bold hover:text-[#1d9bf0] cursor-pointer">Tech News</div>
                                    <div class="text-[#71767b] text-sm">@technews</div>
                                </div>
                            </div>
                            <button class="bg-white text-black px-4 py-1 rounded-full font-semibold text-sm hover:bg-gray-200 transition-colors duration-200">
                                Follow
                            </button>
                        </div>
                    </div>
                    <button class="text-[#1d9bf0] text-sm mt-4 hover:underline">
                        Show more
                    </button>
                </div>

                <!-- Terms -->
                <div class="text-[#71767b] text-sm">
                    <div class="flex flex-wrap gap-2 mb-3">
                        <a href="#" class="hover:text-gray-300">Terms of Service</a>
                        <a href="#" class="hover:text-gray-300">Privacy Policy</a>
                        <a href="#" class="hover:text-gray-300">Cookie Policy</a>
                        <a href="#" class="hover:text-gray-300">Accessibility</a>
                    </div>
                    <p>© 2024 LinkUp Corp.</p>
                </div>
            </div>
        </div>

        <!-- Floating Post Button (Mobile) -->
        @if (!Route::has('login') || !auth()->check())
        <div class="fixed bottom-20 right-4 z-10 md:hidden">
            <a href="{{ route('login') }}" class="bg-[#1d9bf0] text-white w-14 h-14 rounded-full flex items-center justify-center shadow-lg hover:bg-[#1a8cd8] transition-colors duration-200">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M23 3c-6.62-.1-10.38 2.421-13.05 6.03C7.29 12.61 6 17.331 6 22h2c0-1.007.07-2.012.19-3H12c4.1 0 7.48-3.082 7.94-7.054C22.79 10.147 23.17 6.359 23 3zm-7 8h-1.5v2H16c.63 0 1.05.39 1.05.81 0 .43-.52.79-1.16.79H13.5v2H16c1.16 0 2.05-.74 2.05-1.81 0-1.07-.89-1.81-2.05-1.81z"/>
                </svg>
            </a>
        </div>
        @endif
    </body>
</html>