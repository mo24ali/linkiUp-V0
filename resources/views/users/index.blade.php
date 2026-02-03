<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Search Friends') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form action="{{ route('users.index') }}" method="GET" class="mb-6">
                    <div class="flex gap-2">
                        <x-text-input name="query" value="{{ $query }}" placeholder="Search by pseudo or email..."
                            class="w-full" />
                        <x-primary-button>Search</x-primary-button>
                    </div>
                </form>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @forelse($users as $user)
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-xl flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <img src="{{ $user->profile && $user->profile->avatar ? asset('storage/' . $user->profile->avatar) : 'https://i.pravatar.cc/48?u=' . $user->id }}"
                                    class="w-12 h-12 rounded-full">
                                <div>
                                    <a href="{{ route('profile.show', $user->id) }}"
                                        class="font-bold dark:text-white hover:underline">{{ $user->name }}</a>
                                    <p class="text-xs text-gray-500">{{ $user->email }}</p>
                                </div>
                            </div>
                            <form action="{{ route('friends.add', $user->id) }}" method="POST">
                                @csrf
                                <x-secondary-button type="submit">Add</x-secondary-button>
                            </form>
                        </div>
                    @empty
                        @if($query)
                            <div class="col-span-3 text-center py-10 text-gray-500">
                                No users found for "{{ $query }}".
                            </div>
                        @else
                            <div class="col-span-3 text-center py-10 text-gray-500">
                                Enter a pseudo or email to find friends.
                            </div>
                        @endif
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>