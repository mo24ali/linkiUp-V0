<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Friends') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Friend Requests Section -->
            @if(isset($pendingRequests) && $pendingRequests->count() > 0)
            <div class="bg-indigo-50 dark:bg-indigo-900/20 overflow-hidden shadow-sm sm:rounded-lg border border-indigo-100 dark:border-indigo-800">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-indigo-900 dark:text-indigo-200 mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                        Pending Requests
                        <span class="ml-2 bg-indigo-200 dark:bg-indigo-800 text-indigo-800 dark:text-indigo-200 text-xs px-2 py-0.5 rounded-full">{{ $pendingRequests->count() }}</span>
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($pendingRequests as $request)
                            <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-sm flex items-center justify-between border border-gray-100 dark:border-gray-700">
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0">
                                        @if($request->sender->avatar)
                                            <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/' . $request->sender->avatar) }}" alt="{{ $request->sender->name }}">
                                        @else
                                            <div class="h-10 w-10 rounded-full bg-gray-200 dark:bg-gray-600 flex items-center justify-center text-gray-500 dark:text-gray-300 font-bold">
                                                {{ substr($request->sender->name, 0, 1) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                            {{ $request->sender->name }}
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                                            @ {{ $request->sender->pseudo }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex space-x-2">
                                    <button class="p-2 bg-green-100 hover:bg-green-200 text-green-700 dark:bg-green-900/30 dark:hover:bg-green-900/50 dark:text-green-400 rounded-full transition-colors" title="Accept">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    </button>
                                    <button class="p-2 bg-red-100 hover:bg-red-200 text-red-700 dark:bg-red-900/30 dark:hover:bg-red-900/50 dark:text-red-400 rounded-full transition-colors" title="Decline">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- My Friends Section -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        My Friends
                        @if(isset($friends))
                        <span class="ml-2 text-sm text-gray-500 dark:text-gray-400 font-normal">({{ $friends->count() }})</span>
                        @endif
                    </h3>

                    @if(isset($friends) && $friends->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($friends as $friend)
                                <div class="group relative bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4 transition-all hover:bg-white dark:hover:bg-gray-700 hover:shadow-lg border border-transparent hover:border-gray-200 dark:hover:border-gray-600">
                                    <div class="flex items-start space-x-4">
                                        <div class="flex-shrink-0">
                                            @if($friend->avatar)
                                                <img class="h-14 w-14 rounded-full object-cover ring-2 ring-white dark:ring-gray-800" src="{{ asset('storage/' . $friend->avatar) }}" alt="{{ $friend->name }}">
                                            @else
                                                <div class="h-14 w-14 rounded-full bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center text-white font-bold ring-2 ring-white dark:ring-gray-800">
                                                    {{ substr($friend->name, 0, 1) }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <a href="{{ route('users.show', $friend) }}" class="focus:outline-none">
                                                <p class="text-base font-semibold text-gray-900 dark:text-white truncate group-hover:text-indigo-600 dark:group-hover:text-indigo-400">
                                                    {{ $friend->name }}
                                                </p>
                                                <p class="text-sm text-gray-500 dark:text-gray-400 truncate">
                                                    @ {{ $friend->pseudo }}
                                                </p>
                                            </a>
                                            <!-- Additional actions like 'Message' or 'Unfriend' could go here -->
                                            <div class="mt-2 flex space-x-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                                 <button class="text-xs text-indigo-600 dark:text-indigo-400 hover:underline">Message</button>
                                                 <span class="text-gray-300 dark:text-gray-600">|</span>
                                                 <button class="text-xs text-red-600 dark:text-red-400 hover:underline">Unfriend</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12 bg-gray-50 dark:bg-gray-700/30 rounded-lg dashed-border border-2 border-dashed border-gray-300 dark:border-gray-700">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No friends yet</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Get started by searching for people.</p>
                            <div class="mt-6">
                                <a href="{{ route('users.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                    Find People
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
