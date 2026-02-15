<div class="space-y-6">
    {{-- Search Section --}}
    <div class="glass-card p-6">
        <h1 class="text-2xl font-bold text-[#e7e9ea] mb-2">Connect with People</h1>
        <p class="text-[#71767b] mb-6">Search for names, interests, or locations to expand your circle.</p>

        <div class="relative group">
            <input 
                type="text" 
                wire:model.live.debounce.300ms="q"
                placeholder="Search the LinkUp network..."
                class="w-full bg-[#15181c] border-2 border-[#2f3336] group-focus-within:border-[#1d9bf0] rounded-2xl py-4 px-14 text-white text-lg transition-all focus:ring-4 focus:ring-[#1d9bf0]/10 shadow-inner"
                autocomplete="off"
            >
            
            <svg class="w-6 h-6 text-[#71767b] group-focus-within:text-[#1d9bf0] absolute left-5 top-1/2 transform -translate-y-1/2 transition-colors"
                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>

            {{-- Loading Spinner --}}
            <div wire:loading wire:target="q" class="absolute right-5 top-1/2 transform -translate-y-1/2">
                <svg class="animate-spin h-5 w-5 text-[#1d9bf0]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
        </div>
    </div>

    {{-- Search Results --}}
    @if(trim($q) !== '')
        <div class="space-y-6">
            <h2 class="text-xl font-bold text-[#e7e9ea] flex items-center">
                <span class="w-8 h-8 rounded-lg bg-[#f91880]/20 flex items-center justify-center mr-3 text-[#f91880]">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </span>
                Search Results
                <span class="ml-2 text-sm text-[#71767b] font-normal">({{ $this->searchUsers()->count() }} found)</span>
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($this->searchUsers() as $user)
                    <div class="glass-card p-6 flex flex-col items-center text-center group hover:bg-[#1d9bf0]/5 transition-all">
                        <div class="relative mb-4">
                            <img 
                                src="{{ $user->avatar_path ? asset('storage/' . $user->avatar_path) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) }}"
                                class="w-20 h-20 rounded-full object-cover ring-2 ring-[#2f3336] group-hover:ring-[#1d9bf0] transition-all duration-300"
                                alt="{{ $user->name }}"
                            >
                        </div>

                        <h3 class="font-bold text-lg text-[#e7e9ea] mb-1 group-hover:text-[#1d9bf0] transition-colors">
                            {{ $user->name }}
                        </h3>
                        <p class="text-xs text-[#71767b] mb-4">{{ '@' . $user->username }}</p>

                    @if($this->isFriend($user->id))
                        <button type="button" class="w-full py-2.5 bg-[#2f3336] text-white rounded-xl text-sm font-bold" disabled>
                            Friend
                        </button>

                    @elseif($this->hasIncomingRequest($user->id))
                        <div class="flex gap-2 w-full">
                            <button
                                type="button"
                                wire:click="acceptIncoming({{ $user->id }})"
                                class="flex-1 py-2.5 bg-[#1d9bf0] text-white rounded-xl text-sm font-bold">
                                Accept
                            </button>
                    
                            <button
                                type="button"
                                wire:click="rejectIncoming({{ $user->id }})"
                                class="flex-1 py-2.5 bg-[#2f3336] text-white rounded-xl text-sm font-bold">
                                Reject
                            </button>
                        </div>
                    

                    @elseif($this->hasSentRequest($user->id))
                        <button type="button" wire:click="cancelRequest({{ $user->id }})" class="w-full py-2.5 bg-[#f91880] text-white rounded-xl text-sm font-bold border ">
                            Cancel Request
                        </button>

                    @else
                        <button type="button" wire:click="addFriend({{ $user->id }})" class="w-full py-2.5 bg-[#e7e9ea] text-[#0f1419] rounded-xl text-sm font-bold">
                            Add Friend
                        </button>
                    @endif


                    </div>
                @empty
                    <div class="col-span-full">
                        <div class="text-center py-20 bg-[#15181c] rounded-3xl border border-[#2f3336]">
                            <svg class="mx-auto h-16 w-16 text-[#71767b] mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 9.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <h3 class="text-xl font-bold text-[#e7e9ea]">No matches found</h3>
                            <p class="text-[#71767b]">Try searching for "{{ $q }}"</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    @endif
</div>