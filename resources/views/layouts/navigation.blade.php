<nav x-data="{ open: false }" class="bg-black border-b border-[#2f3336]">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between h-16 items-center">
            <!-- Logo -->
            <div class="shrink-0">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-[#1d9bf0] rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold">L</span>
                    </div>
                    <span class="text-xl font-bold hidden sm:inline">LinkUp</span>
                </a>
            </div>

            <!-- Navigation Links -->
            <div class="hidden sm:flex sm:items-center sm:space-x-6">
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 1.696L.622 8.807l1.06 1.696L3 9.679v9.57C3 21.295 4.652 23 6.736 23h10.528C19.348 23 21 21.295 21 19.249v-9.57l1.318.824 1.06-1.696L12 1.696zM12 3.054l8 5v10.195c0 1.126-.956 2.041-2.136 2.041H6.136C4.956 20.29 4 19.375 4 18.249V8.054l8-5z"/>
                    </svg>
                    {{ __('Home') }}
                </x-nav-link>
                <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M10.25 3.75c-3.59 0-6.5 2.91-6.5 6.5s2.91 6.5 6.5 6.5c1.795 0 3.419-.726 4.596-1.904l1.204 1.204h-3.8v-3.8l1.204 1.204c.65-.65 1.046-1.546 1.046-2.504 0-3.59-2.91-6.5-6.5-6.5z"/>
                    </svg>
                    {{ __('Explore') }}
                </x-nav-link>
                <x-nav-link :href="route('friends.index')" :active="request()->routeIs('friends.index')">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.863 13.44c1.477 1.58 2.366 3.8 2.632 6.46l.11 1.1H3.395l.11-1.1c.266-2.66 1.155-4.88 2.632-6.46C7.627 11.85 9.648 11 12 11c2.352 0 4.373.85 5.863 2.44zM12 2C9.791 2 8 3.79 8 6s1.791 4 4 4 4-1.79 4-4-1.791-4-4-4z"/>
                    </svg>
                    {{ __('Friends') }}
                </x-nav-link>
            </div>

            <!-- Right Side -->
            <div class="flex items-center space-x-4">
                <!-- Search Button (Mobile) -->
                <button class="sm:hidden text-[#71767b] hover:text-[#e7e9ea] p-2">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M10.25 3.75c-3.59 0-6.5 2.91-6.5 6.5s2.91 6.5 6.5 6.5c1.795 0 3.419-.726 4.596-1.904l1.204 1.204h-3.8v-3.8l1.204 1.204c.65-.65 1.046-1.546 1.046-2.504 0-3.59-2.91-6.5-6.5-6.5z"/>
                    </svg>
                </button>

                <!-- Settings Dropdown -->
                <div class="hidden sm:block">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center space-x-2 hover:bg-[#181818] p-2 rounded-full transition-colors">
                                <div class="w-8 h-8 bg-[#333] rounded-full flex items-center justify-center">
                                    <span class="text-white text-sm">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                </div>
                                <div class="hidden md:block text-sm font-medium">{{ Auth::user()->name }}</div>
                                <svg class="w-4 h-4 text-[#71767b]" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M3 12a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0zm7.5 0a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0zm7.5 0a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0z"/>
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('users.show', Auth::user())" class="text-sm">
                                {{ __('My Profile') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('profile.edit')" class="text-sm">
                                {{ __('Settings') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();
                                                    this.closest('form').submit();" class="text-sm">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>

                <!-- Hamburger Menu -->
                <button @click="open = ! open" class="sm:hidden text-[#71767b] hover:text-[#e7e9ea] p-2 rounded-full hover:bg-[#181818]">
                    <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-black border-t border-[#2f3336]">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 1.696L.622 8.807l1.06 1.696L3 9.679v9.57C3 21.295 4.652 23 6.736 23h10.528C19.348 23 21 21.295 21 19.249v-9.57l1.318.824 1.06-1.696L12 1.696zM12 3.054l8 5v10.195c0 1.126-.956 2.041-2.136 2.041H6.136C4.956 20.29 4 19.375 4 18.249V8.054l8-5z"/>
                </svg>
                {{ __('Home') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')">
                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M10.25 3.75c-3.59 0-6.5 2.91-6.5 6.5s2.91 6.5 6.5 6.5c1.795 0 3.419-.726 4.596-1.904l1.204 1.204h-3.8v-3.8l1.204 1.204c.65-.65 1.046-1.546 1.046-2.504 0-3.59-2.91-6.5-6.5-6.5z"/>
                </svg>
                {{ __('Explore') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('friends.index')" :active="request()->routeIs('friends.index')">
                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.863 13.44c1.477 1.58 2.366 3.8 2.632 6.46l.11 1.1H3.395l.11-1.1c.266-2.66 1.155-4.88 2.632-6.46C7.627 11.85 9.648 11 12 11c2.352 0 4.373.85 5.863 2.44zM12 2C9.791 2 8 3.79 8 6s1.791 4 4 4 4-1.79 4-4-1.791-4-4-4z"/>
                </svg>
                {{ __('Friends') }}
            </x-responsive-nav-link>
        </div>

        <!-- Mobile Profile Section -->
        <div class="pt-4 pb-3 border-t border-[#2f3336]">
            <div class="px-4 mb-3">
                <div class="text-base font-medium">{{ Auth::user()->name }}</div>
                <div class="text-sm text-[#71767b]">{{ Auth::user()->email }}</div>
            </div>

            <div class="space-y-1">
                <x-responsive-nav-link :href="route('users.show', Auth::user())">
                    {{ __('My Profile') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Settings') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>