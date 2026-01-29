<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Find People') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Search Bar -->
                    <div class="mb-8 max-w-2xl mx-auto">
                        <form action="{{ route('users.index') }}" method="GET" class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                            </div>
                            <input type="text" name="search" id="search" class="block w-full p-4 pl-10 text-sm text-gray-900 border border-gray-300 rounded-full bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300 shadow-sm hover:shadow-md" placeholder="Search by pseudo or email..." required value="{{ request('search') }}">
                            <button type="submit" class="text-white absolute right-2.5 bottom-2.5 bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-full text-sm px-6 py-2 dark:bg-indigo-500 dark:hover:bg-indigo-600 dark:focus:ring-indigo-800 transition-colors duration-200">Search</button>
                        </form>
                    </div>

                    <!-- Users Grid -->
                    @if(isset($users) && $users->count() > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                            @foreach($users as $user)
                                <div class="bg-white dark:bg-gray-700/50 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 overflow-hidden border border-gray-100 dark:border-gray-600 group">
                                    <div class="h-24 bg-gradient-to-r from-purple-500 to-indigo-600 relative">
                                        <!-- Optional: Cover image pattern -->
                                        <div class="absolute inset-0 opacity-20 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
                                    </div>
                                    <div class="px-4 pb-4 relative">
                                        <div class="relative -mt-12 mb-3 flex justify-center">
                                            <div class="h-24 w-24 rounded-full border-4 border-white dark:border-gray-700 overflow-hidden shadow-md bg-gray-200">
                                                @if($user->avatar)
                                                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->pseudo }}" class="object-cover w-full h-full">
                                                @else
                                                    <div class="flex items-center justify-center w-full h-full text-2xl font-bold text-gray-400 bg-gray-100 dark:bg-gray-800">
                                                        {{ substr($user->name, 0, 1) }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <div class="text-center mb-4">
                                            <h3 class="text-lg font-bold text-gray-800 dark:text-white truncate" title="{{ $user->name }}">{{ $user->name }}</h3>
                                            <p class="text-sm text-indigo-500 font-medium truncate">@ {{ $user->pseudo ?? 'user' }}</p>
                                            @if($user->bio)
                                                <p class="text-xs text-gray-500 dark:text-gray-300 mt-2 line-clamp-2 h-8">{{ $user->bio }}</p>
                                            @else
                                                 <p class="text-xs text-gray-400 dark:text-gray-500 mt-2 italic h-8">No bio available</p>
                                            @endif
                                        </div>

                                        <div class="flex gap-2 justify-center">
                                            <a href="{{ route('users.show', $user) }}" class="flex-1 text-center bg-gray-100 hover:bg-gray-200 dark:bg-gray-600 dark:hover:bg-gray-500 text-gray-800 dark:text-white py-2 px-4 rounded-lg text-sm font-medium transition-colors">
                                                Profile
                                            </a>
                                            <!-- Add Friend Button Logic would go here -->
                                            <!-- Example placeholder -->
                                            <button class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded-lg text-sm font-medium transition-colors shadow-sm dark:bg-indigo-500 dark:hover:bg-indigo-600">
                                                <i class="fas fa-user-plus mr-1"></i> Add
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="mt-6">
                            {{ $users->links() }}
                        </div>
                    @elseif(request('search'))
                         <div class="text-center py-12">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-700 mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">No users found</h3>
                            <p class="mt-1 text-gray-500 dark:text-gray-400">Try adjusting your search terms.</p>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Begin your search</h3>
                            <p class="mt-1 text-gray-500 dark:text-gray-400">Find friends by searching for their pseudo or email.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
