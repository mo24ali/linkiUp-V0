<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl tracking-tight text-[#e7e9ea]">
                {{ __('Friends Network') }}
            </h2>
            <a href="{{ route('friends.page') }}" class="btn-vibrant py-2 px-6 text-sm">
                Add New Friends
            </a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto space-y-8">
        <!-- Pending Requests Section -->
        @if(isset($pendingRequests) && $pendingRequests->count() > 0)
            <div class="glass-card p-6 border-l-4 border-[#1d9bf0]">
                <h3 class="text-xl font-bold text-[#e7e9ea] mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-3 text-[#1d9bf0]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                    Pending Requests
                    <span
                        class="ml-3 bg-[#1d9bf0]/20 text-[#1d9bf0] text-xs px-2.5 py-1 rounded-full border border-[#1d9bf0]/30">{{ $pendingRequests->count() }}</span>
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($pendingRequests as $request)
                        <div
                            class="bg-[#15181c] p-4 rounded-2xl border border-[#2f3336] flex items-center justify-between group hover:border-[#1d9bf0]/50 transition-all">
                            <div class="flex items-center space-x-3">
                                <img class="h-12 w-12 rounded-full object-cover ring-2 ring-[#2f3336] group-hover:ring-[#1d9bf0]/50 transition-all"
                                    src="{{ $request->sender->profile && $request->sender->profile->avatar ? Storage::url($request->sender->profile->avatar) : 'https://i.pravatar.cc/150?u=' . $request->sender->id }}"
                                    alt="{{ $request->sender->name }}">
                                <div class="min-w-0">
                                    <p class="text-sm font-bold text-[#e7e9ea] truncate">
                                        {{ $request->sender->name }}
                                    </p>
                                    <p class="text-xs text-[#71767b] truncate">
                                        Sent you a request
                                    </p>
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                <form action="{{ route('friends.accept', $request->sender_id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="p-2.5 bg-[#1d9bf0]/10 hover:bg-[#1d9bf0]/20 text-[#1d9bf0] rounded-xl transition-all border border-[#1d9bf0]/20"
                                        title="Accept">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </button>
                                </form>
                                <form action="{{ route('friends.reject', $request->sender_id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="p-2.5 bg-[#f91880]/10 hover:bg-[#f91880]/20 text-[#f91880] rounded-xl transition-all border border-[#f91880]/20"
                                        title="Decline">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- My Friends Section -->
        <div class="glass-card p-8">
            <h3 class="text-2xl font-bold text-[#e7e9ea] mb-8 flex items-center">
                <svg class="w-7 h-7 mr-3 text-[#1d9bf0]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                    </path>
                </svg>
                My Circle
                @if(isset($friends))
                    <span
                        class="ml-3 text-sm text-[#71767b] font-medium px-3 py-1 bg-[#2f3336] rounded-full">{{ $friends->count() }}
                        connections</span>
                @endif
            </h3>

            @if(isset($friends) && $friends->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($friends as $friend)
                        <div
                            class="group bg-[#15181c] rounded-2xl p-5 transition-all hover:bg-[#1d9bf0]/5 border border-[#2f3336] hover:border-[#1d9bf0]/30 hover:shadow-[0_0_20px_rgba(29,155,240,0.1)]">
                            <div class="flex flex-col items-center text-center">
                                <div class="relative mb-4">
                                    <img class="h-20 w-20 rounded-full object-cover ring-2 ring-[#2f3336] group-hover:ring-[#1d9bf0] transition-all duration-500"
                                        src="{{ $friend->profile && $friend->profile->avatar ? Storage::url($friend->profile->avatar) : 'https://i.pravatar.cc/150?u=' . $friend->id }}"
                                        alt="{{ $friend->name }}">
                                    <div
                                        class="absolute bottom-1 right-1 w-4 h-4 bg-green-500 border-2 border-[#15181c] rounded-full">
                                    </div>
                                </div>

                                <a href="{{ route('profile.show', $friend->id) }}" class="block w-full">
                                    <h4
                                        class="text-base font-bold text-[#e7e9ea] truncate group-hover:text-[#1d9bf0] transition-colors">
                                        {{ $friend->name }}
                                    </h4>
                                    <p class="text-sm text-[#71767b] truncate mb-4">
                                        @ {{ Str::slug($friend->name) }}
                                    </p>
                                </a>

                                <div class="flex w-full space-x-2">
                                    <a href="{{ route('messagerie.index') }}"
                                        class="flex-1 py-2 rounded-xl bg-[#2f3336] hover:bg-[#1d9bf0] text-white text-xs font-bold transition-all flex items-center justify-center">
                                        Message
                                    </a>
                                    <button
                                        class="p-2 rounded-xl bg-[#f91880]/10 text-[#f91880] hover:bg-[#f91880] hover:text-white transition-all border border-[#f91880]/20">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-16 bg-[#15181c] rounded-3xl border-2 border-dashed border-[#2f3336]">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-[#1d9bf0]/10 rounded-full mb-6">
                        <svg class="h-10 w-10 text-[#1d9bf0]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-[#e7e9ea] mb-2">No connections yet</h3>
                    <p class="text-[#71767b] mb-8 max-w-sm mx-auto">Build your network by discovering people with common
                        interests.</p>
                    <a href="{{ route('friends.page') }}" class="btn-vibrant inline-flex items-center">
                        <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Discover People
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>