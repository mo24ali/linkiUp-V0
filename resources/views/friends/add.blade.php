<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Find Friends') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                    Find Friends
                </h1>
                <p class="mt-2 text-gray-600 dark:text-gray-400">
                    Search for people you know and add them to your friends list.
                </p>
            </div>

            {{-- Livewire Search Component --}}
            <livewire:friend-search />

            {{-- Suggestions Section --}}
            @if(isset($suggestions) && count($suggestions) > 0)
                <div class="mt-12">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">
                        Suggested People
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($suggestions as $user)
                            <div
                                class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 flex flex-col items-center text-center hover:shadow-md transition-shadow">
                                <img src="{{ $user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&color=7F9CF5&background=EBF4FF' }}"
                                    class="w-20 h-20 rounded-full mb-4 object-cover ring-4 ring-gray-50 dark:ring-gray-700" />
                                <h3 class="font-bold text-lg text-gray-900 dark:text-white mb-1">{{ $user->name }}</h3>
                                <p class="text-sm text-gray-500 mb-4">{{ '@' . $user->pseudo }}</p>

                                <form action="{{ route('friends.add', $user->id) }}" method="POST" class="w-full">
                                    @csrf
                                    <button
                                        class="w-full py-2 px-4 bg-white border border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white rounded-lg text-sm font-medium hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors flex items-center justify-center">
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
                </div>
            @endif
        </div>
    </div>
</x-app-layout>