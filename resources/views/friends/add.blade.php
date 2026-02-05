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
            {{-- Search Form --}}
            <form action="{{ route('friends.page') }}" method="GET" class="relative mb-8">
                <input type="text" name="search" placeholder="Search by name or email..."
                    value="{{ request('search') }}"
                    class="w-full bg-white dark:bg-gray-800 border-none rounded-xl py-3 px-12 text-gray-900 dark:text-white shadow-sm focus:ring-2 focus:ring-blue-500">
                <svg class="w-6 h-6 text-gray-400 absolute left-4 top-1/2 transform -translate-y-1/2" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </form>
            @php

            @endphp

            {{-- Pending Invitations Section --}}
            @if(isset($pendingInvitations) && $pendingInvitations->count() > 0)
                <div class="mb-12">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">
                        Pending Invitations
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($pendingInvitations as $invitation)
                            <div
                                class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 flex flex-col items-center text-center">
                                <img src="{{ $invitation->sender->profile && $invitation->sender->profile->avatar ? Storage::url($invitation->sender->profile->avatar) : 'https://i.pravatar.cc/150?u=' . $invitation->sender->id }}"
                                    class="w-20 h-20 rounded-full mb-4 object-cover ring-4 ring-gray-50 dark:ring-gray-700">
                                <h3 class="font-bold text-lg text-gray-900 dark:text-white mb-1">{{ $invitation->sender->name }}
                                </h3>
                                <p class="text-sm text-gray-500 mb-4">Sent you a friend request</p>

                                <div class="flex gap-2 w-full">
                                    <form action="{{ route('friends.accept', $invitation->sender_id) }}" method="POST"
                                        class="flex-1">
                                        @csrf
                                        <button
                                            class="w-full py-2 bg-blue-600 text-white rounded-lg text-sm font-bold hover:bg-blue-700 transition">Accept</button>
                                    </form>
                                    <form action="{{ route('friends.reject', $invitation->sender_id) }}" method="POST"
                                        class="flex-1">
                                        @csrf
                                        <button
                                            class="w-full py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-lg text-sm font-bold hover:bg-gray-300 dark:hover:bg-gray-600 transition">Reject</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

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

                                <form action="{{ route('friends.add', $user->id)}}" method="POST" class="w-full">
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