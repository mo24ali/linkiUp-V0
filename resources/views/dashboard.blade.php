<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <h2 class="text-xl font-bold mb-4">
                        👥 People you may know
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                        @forelse($users as $user)
                            <div
                                class="flex items-center justify-between p-4 border rounded-lg dark:border-gray-700 bg-gray-50 dark:bg-gray-900">

                                <div class="flex items-center gap-4">
                                    {{-- Avatar --}}
                                    <img src="{{ $user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name) }}"
                                        class="w-12 h-12 rounded-full" />

                                    <div>
                                        <p class="font-semibold">{{ $user->name }}</p>
                                        <p class="text-sm text-gray-500">
                                            {{ $user->email }}
                                        </p>
                                    </div>
                                </div>

                                {{-- Add Friend Button --}}
                                <form action="{{ route('friends.add', $user->id) }}" method="POST">
                                    @csrf
                                    <button class="px-3 py-1 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">
                                        Add
                                    </button>
                                </form>

                            </div>
                        @empty
                            <p class="text-gray-500">No suggestions found.</p>
                        @endforelse

                    </div>

                </div>

            </div>
        </div>
    </div>

</x-app-layout>