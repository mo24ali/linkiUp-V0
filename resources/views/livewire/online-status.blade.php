<div wire:poll.3s="refreshStatus">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach($friends as $friend)
            <div class="group bg-[#15181c] rounded-2xl p-5 transition-all hover:bg-[#1d9bf0]/5 border border-[#2f3336] hover:border-[#1d9bf0]/30 hover:shadow-[0_0_20px_rgba(29,155,240,0.1)]">
                <div class="flex flex-col items-center text-center">
                    <div class="relative mb-4">
                        <img class="h-20 w-20 rounded-full object-cover ring-2 ring-[#2f3336] group-hover:ring-[#1d9bf0] transition-all duration-500"
                            src="{{ $friend->profile && $friend->profile->avatar ? Storage::url($friend->profile->avatar) : 'https://i.pravatar.cc/150?u=' . $friend->id }}"
                            alt="{{ $friend->name }}">
                        
                        <div class="absolute bottom-1 right-1 w-4 h-4 border-2 border-[#15181c] rounded-full transition-colors duration-500 {{ $friend->is_online ? 'bg-green-500' : 'bg-gray-500' }}">
                        </div>
                    </div>

                    <a href="{{ route('profile.show', $friend->id) }}" class="block w-full">
                        <h4 class="text-base font-bold text-[#e7e9ea] truncate group-hover:text-[#1d9bf0] transition-colors">
                            {{ $friend->name }}
                        </h4>
                        <p class="text-xs text-[#71767b] truncate mb-4 {{ $friend->is_online ? 'text-green-500' : 'text-[#71767b]' }}">
                            {{ $friend->is_online ? 'Online now' : 'Offline' }}
                        </p>
                    </a>

                    <div class="flex w-full space-x-2">
                        <a href="{{ route('messagerie.index') }}" class="flex-1 py-2 rounded-xl bg-[#2f3336] hover:bg-[#1d9bf0] text-white text-xs font-bold transition-all flex items-center justify-center">
                            Message
                        </a>
                        <button wire:click="removeFriend({{$friend->id}})"
                            onclick="confirm('Delete this friend ? ')"
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
</div>