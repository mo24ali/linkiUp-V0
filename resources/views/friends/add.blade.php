@extends('layouts.app')

@section('content')
<div class="py-10">
    <div class="max-w-6xl mx-auto px-4">

        {{-- Title --}}
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">
            👥 Friend Suggestions
        </h1>

        {{-- Flash message --}}
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif
        <livewire:friend-search />

        {{-- Users Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            @forelse($users as $user)
                <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-4 flex items-center justify-between">

                    <div class="flex items-center gap-4">
                        {{-- Avatar --}}
                        <img 
                            src="{{ $user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name) }}"
                            class="w-12 h-12 rounded-full border"
                        />

                        <div>
                            <h3 class="font-semibold text-gray-900 dark:text-white">
                                {{ $user->name }}
                            </h3>
                            <p class="text-sm text-gray-500">
                                {{ $user->email }}
                            </p>
                        </div>
                    </div>

                    {{-- Add Friend Button --}}
                    <form action="{{ route('friends.add', $user->id) }}" method="POST">
                        @csrf
                        <button 
                            class="px-4 py-1 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm"
                        >
                            ➕ Add
                        </button>
                    </form>

                </div>
            @empty
                <div class="col-span-3 text-center text-gray-500">
                    No users found 😢
                </div>
            @endforelse

        </div>

    </div>
</div>
@endsection
