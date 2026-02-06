<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl tracking-tight text-[#e7e9ea]">
                {{ __('Find Friends') }}
            </h2>
            <div class="flex items-center space-x-2">
                <span class="text-xs text-[#71767b] font-medium uppercase tracking-widest">Discovery Mode</span>
                <span class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></span>
            </div>
        </div>
    </x-slot>

    <div class="max-w-5xl mx-auto space-y-10">
        {{-- Search Section --}}
        <div class="glass-card p-6">
            <h1 class="text-2xl font-bold text-[#e7e9ea] mb-2">Connect with People</h1>
            <p class="text-[#71767b] mb-6">Search for names, interests, or locations to expand your circle.</p>

            <form action="{{ route('friends.page') }}" method="GET" class="relative group">
                <input type="text" name="search" placeholder="Search the LinkUp network..."
                    value="{{ request('search') }}"
                    class="w-full bg-[#15181c] border-2 border-[#2f3336] group-focus-within:border-[#1d9bf0] rounded-2xl py-4 px-14 text-white text-lg transition-all focus:ring-4 focus:ring-[#1d9bf0]/10 shadow-inner">
                <svg class="w-6 h-6 text-[#71767b] group-focus-within:text-[#1d9bf0] absolute left-5 top-1/2 transform -translate-y-1/2 transition-colors"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </form>
        </div>

        {{-- Pending Invitations Section --}}
        @if(isset($pendingInvitations) && $pendingInvitations->count() > 0)
            <div class="space-y-6">
                <h2 class="text-xl font-bold text-[#e7e9ea] flex items-center">
                    <span class="w-8 h-8 rounded-lg bg-[#1d9bf0]/20 flex items-center justify-center mr-3 text-[#1d9bf0]">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                    </span>
                    Incoming Requests
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($pendingInvitations as $invitation)
                        <div class="glass-card p-6 flex flex-col items-center text-center group">
                            <div class="relative mb-4">
                                <img src="{{ $invitation->sender->profile && $invitation->sender->profile->avatar ? Storage::url($invitation->sender->profile->avatar) : 'https://i.pravatar.cc/150?u=' . $invitation->sender->id }}"
                                    class="w-24 h-24 rounded-full object-cover ring-4 ring-[#2f3336] group-hover:ring-[#1d9bf0] transition-all duration-500">
                                <div
                                    class="absolute inset-0 rounded-full bg-[#1d9bf0] animate-ping opacity-10 group-hover:opacity-20 transition-opacity">
                                </div>
                            </div>

                            <h3 class="font-bold text-xl text-[#e7e9ea] mb-1 group-hover:text-[#1d9bf0] transition-colors">
                                {{ $invitation->sender->name }}</h3>
                            <p class="text-sm text-[#71767b] mb-6">Wants to join your circle</p>

                            <div class="flex gap-3 w-full">
                                <form action="{{ route('friends.accept', $invitation->sender_id) }}" method="POST"
                                    class="flex-1">
                                    @csrf
                                    <button
                                        class="w-full py-2.5 bg-[#1d9bf0] hover:bg-[#1a8cd8] text-white rounded-xl text-sm font-bold transition-all shadow-lg shadow-[#1d9bf0]/20">
                                        Accept
                                    </button>
                                </form>
                                <form action="{{ route('friends.reject', $invitation->sender_id) }}" method="POST"
                                    class="flex-1">
                                    @csrf
                                    <button
                                        class="w-full py-2.5 bg-[#2f3336] hover:bg-[#3d4246] text-[#e7e9ea] rounded-xl text-sm font-bold transition-all">
                                        Decline
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Suggestions/Search Results Section --}}
        <div class="space-y-6">
            <h2 class="text-xl font-bold text-[#e7e9ea] flex items-center">
                <span class="w-8 h-8 rounded-lg bg-[#f91880]/20 flex items-center justify-center mr-3 text-[#f91880]">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </span>
                {{ request('search') ? 'Search Results' : 'Recommended for You' }}
            </h2>

            @if(isset($suggestions) && count($suggestions) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($suggestions as $user)
                        <div
                            class="glass-card p-6 flex flex-col items-center text-center group hover:bg-[#1d9bf0]/5 transition-all">
                            <div class="relative mb-4">
                                <img src="{{ $user->profile && $user->profile->avatar ? Storage::url($user->profile->avatar) : 'https://i.pravatar.cc/150?u=' . $user->id }}"
                                    class="w-20 h-20 rounded-full object-cover ring-2 ring-[#2f3336] group-hover:ring-[#1d9bf0] transition-all duration-300">
                            </div>

                            <h3 class="font-bold text-lg text-[#e7e9ea] mb-1 group-hover:text-[#1d9bf0] transition-colors">
                                {{ $user->name }}</h3>
                            <p class="text-xs text-[#71767b] mb-4">@ {{ Str::slug($user->name) }}</p>

                            <form action="{{ route('friends.add', $user->id)}}" method="POST" class="w-full">
                                @csrf
                                <button
                                    class="w-full py-2.5 bg-[#e7e9ea] text-[#0f1419] rounded-xl text-sm font-bold hover:bg-[#d7d9d9] transition-all flex items-center justify-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Add Friend
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-20 bg-[#15181c] rounded-3xl border border-[#2f3336]">
                    <svg class="mx-auto h-16 w-16 text-[#71767b] mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9.172 9.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="text-xl font-bold text-[#e7e9ea]">No matches found</h3>
                    <p class="text-[#71767b]">Try searching for different keywords or names.</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>