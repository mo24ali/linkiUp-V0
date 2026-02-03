<div class="space-y-6">
    {{-- Search Input --}}
    <div class="relative">
        <input type="text" wire:model.debounce.300ms="search" placeholder="Search friends by name or email..."
            class="w-full px-5 py-3 rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-all text-base">
        <div class="absolute right-4 top-3.5 text-gray-400">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </div>
    </div>

    {{-- Feedback Message: Success or Status --}}
    @if(session()->has('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
            class="bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 px-4 py-2 rounded-lg text-sm flex items-center shadow-sm">
            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Results --}}
    <div class="transition-all">
        @if(strlen($search) > 1)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg ring-1 ring-black ring-opacity-5 overflow-hidden">
                @forelse($users as $user)
                    <div
                        class="p-4 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between hover:bg-gray-50 dark:hover:bg-gray-700/50 transition duration-150 last:border-0">
                        <div class="flex items-center space-x-4">
                            <img src="{{ $user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&color=7F9CF5&background=EBF4FF' }}"
                                class="w-10 h-10 rounded-full object-cover ring-2 ring-gray-100 dark:ring-gray-700" />
                            <div>
                                <h3 class="font-semibold text-gray-900 dark:text-gray-100">{{ $user->name }}</h3>
                                <p class="text-xs text-gray-500">{{ $user->email }} | {{ '@' . $user->pseudo }}</p>
                            </div>
                        </div>

                        <button wire:click="addFriend({{ $user->id }})" wire:loading.attr="disabled"
                            class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 disabled:opacity-50 text-white text-sm font-medium rounded-lg transition-colors flex items-center shadow-sm">
                            <svg wire:loading.remove wire:target="addFriend({{ $user->id }})" class="w-4 h-4 mr-1.5" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <svg wire:loading wire:target="addFriend({{ $user->id }})"
                                class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                                </circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            <span wire:loading.remove wire:target="addFriend({{ $user->id }})">Add</span>
                            <span wire:loading wire:target="addFriend({{ $user->id }})">...</span>
                        </button>
                    </div>
                @empty
                    <div class="p-8 text-center text-gray-500 dark:text-gray-400">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="mt-2">No users found matching "{{ $search }}"</p>
                    </div>
                @endforelse
            </div>
        @endif
    </div>
</div>