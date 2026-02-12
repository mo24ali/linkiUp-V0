<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl tracking-tight text-[#e7e9ea]">
                {{ __('Explore Network') }}
            </h2>
            <div class="flex items-center space-x-2">
                <div class="flex -space-x-2 overflow-hidden">
                    <img class="inline-block h-8 w-8 rounded-full ring-2 ring-[#15181c]" src="https://i.pravatar.cc/100?u=1" alt="">
                    <img class="inline-block h-8 w-8 rounded-full ring-2 ring-[#15181c]" src="https://i.pravatar.cc/100?u=2" alt="">
                    <img class="inline-block h-8 w-8 rounded-full ring-2 ring-[#15181c]" src="https://i.pravatar.cc/100?u=3" alt="">
                </div>
                <span class="text-xs text-[#71767b] font-medium tracking-wide">Join 2k+ users</span>
            </div>
        </div>
    </x-slot>

    <div class="max-w-6xl mx-auto space-y-12">
        {{-- Hero Search --}}
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-[#1d9bf0]/10 via-transparent to-[#f91880]/10 p-1">
            <div class="glass-card p-8 md:p-12 text-center">
                <h1 class="text-4xl md:text-5xl font-black text-white mb-4 tracking-tight">Discover Your Circle</h1>
                
                <livewire:test/>
            </div>
        </div>

        {{-- Results Grid --}}
        <div class="space-y-8">
            <div class="flex items-center justify-between border-b border-[#2f3336] pb-4">
                <h3 class="text-xl font-bold text-[#e7e9ea]">
                    {{ $query ? "Results for \"$query\"" : "Global Users" }}
                </h3>
                <span class="text-sm text-[#71767b] font-medium uppercase tracking-widest">Random Discovery</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($users as $user)
                    <div class="glass-card p-6 flex items-center justify-between group hover:border-[#1d9bf0]/50 hover:shadow-[0_0_30px_rgba(29,155,240,0.05)] transition-all duration-300">
                        <div class="flex items-center gap-4">
                            <div class="relative">
                                <img src="{{ $user->profile && $user->profile->avatar ? Storage::url($user->profile->avatar) : 'https://i.pravatar.cc/100?u=' . $user->id }}"
                                    class="w-16 h-16 rounded-full object-cover ring-2 ring-[#2f3336] group-hover:ring-[#1d9bf0] transition-all">
                                <div class="absolute -bottom-1 -right-1 bg-blue-500 rounded-full p-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293l-4 4a1 1 0 01-1.414 0l-2-2a1 1 0 111.414-1.414L9 10.586l3.293-3.293a1 1 0 111.414 1.414z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="min-w-0">
                                <a href="{{ route('profile.show', $user->id) }}"
                                    class="font-bold text-[#e7e9ea] hover:text-[#1d9bf0] hover:underline transition-colors block truncate">{{ $user->name }}</a>
                                <p class="text-xs text-[#71767b] truncate tracking-wide">@ {{ Str::slug($user->name) }}</p>
                            </div>
                        </div>
                        
                        <form action="{{ route('friends.add', $user->id) }}" method="POST" class="ml-4">
                            @csrf
                            <button type="submit" class="p-3 rounded-2xl bg-[#1d9bf0]/10 text-[#1d9bf0] hover:bg-[#1d9bf0] hover:text-white transition-all border border-[#1d9bf0]/20 shadow-lg">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                            </button>
                        </form>
                    </div>
                @empty
                    <div class="col-span-full text-center py-20 bg-[#15181c] rounded-3xl border border-[#2f3336]">
                        <div class="w-20 h-20 bg-[#2f3336] rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-[#71767b]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-2">No users found</h3>
                        <p class="text-[#71767b] max-w-sm mx-auto">We couldn't find anyone matching "{{ $query }}". Try a different name or just browse the community.</p>
                        <a href="{{ route('users.index') }}" class="inline-block mt-8 text-[#1d9bf0] hover:underline font-bold">Clear search</a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>