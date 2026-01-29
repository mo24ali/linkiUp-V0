<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $user->pseudo ?? $user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                <!-- Profile Header -->
                <div class="relative h-48 bg-gradient-to-r from-blue-500 to-purple-600">
                    <div
                        class="absolute inset-0 opacity-30 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]">
                    </div>
                </div>

                <!-- Profile Info -->
                <div class="relative px-6 pb-6">
                    <div class="flex flex-col sm:flex-row items-center sm:items-end -mt-16 mb-6">
                        <!-- Avatar -->
                        <div class="relative">
                            <div
                                class="h-32 w-32 rounded-full border-4 border-white dark:border-gray-800 overflow-hidden shadow-lg bg-gray-200">
                                @if($user->avatar)
                                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->pseudo }}"
                                        class="object-cover w-full h-full">
                                @else
                                    <div
                                        class="flex items-center justify-center w-full h-full text-4xl font-bold text-gray-400 bg-gray-100 dark:bg-gray-700">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Name & Pseudo -->
                        <div class="mt-4 sm:mt-0 sm:ml-6 text-center sm:text-left flex-1">
                            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $user->name }}</h1>
                            <p class="text-indigo-600 dark:text-indigo-400 font-medium text-lg">@ {{ $user->pseudo }}
                            </p>
                        </div>

                        <!-- Actions -->
                        <div class="mt-6 sm:mt-0 sm:ml-auto flex gap-3">
                            @if(auth()->id() !== $user->id)
                                <!-- Friend Request Button Placeholder -->
                                <button
                                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-full font-medium shadow-md transition-colors flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Add Friend
                                </button>
                                <!-- Map Message Button -->
                                <button
                                    class="bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-white px-4 py-2 rounded-full font-medium shadow-sm transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                        </path>
                                    </svg>
                                </button>
                            @else
                                <a href="{{ route('profile.edit') }}"
                                    class="bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-white px-6 py-2 rounded-full font-medium shadow-sm transition-colors flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                        </path>
                                    </svg>
                                    Edit Profile
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Bio Section -->
                    <div class="mt-8 border-t border-gray-200 dark:border-gray-700 pt-6">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">About</h3>
                        <div
                            class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-6 text-gray-700 dark:text-gray-300 leading-relaxed shadow-inner">
                            @if($user->bio)
                                {{ $user->bio }}
                            @else
                                <span class="italic text-gray-500">No bio provided.</span>
                            @endif
                        </div>
                    </div>

                    <!-- Additional Details (Email, Join Date) -->
                    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="flex items-center text-gray-600 dark:text-gray-400">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg>
                            <span>{{ $user->email }}</span>
                        </div>
                        <div class="flex items-center text-gray-600 dark:text-gray-400">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                            <span>Joined {{ $user->created_at->format('F Y') }}</span>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>