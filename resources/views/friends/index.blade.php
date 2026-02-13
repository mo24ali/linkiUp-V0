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

            <!-- Livewire Online Status Component -->
            @livewire('online-status')
        </div>
    </div>
</x-app-layout>