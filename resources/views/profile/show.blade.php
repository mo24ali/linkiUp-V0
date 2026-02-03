<x-app-layout>
        <x-slot name="header">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        {{ $user->name }}'s Profile
                </h2>
        </x-slot>

        <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                        <div
                                class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg flex items-center space-x-6">
                                <img src="{{ $user->profile && $user->profile->avatar ? asset('storage/' . $user->profile->avatar) : 'https://i.pravatar.cc/150?u=' . $user->id }}"
                                        class="w-32 h-32 rounded-full border-4 border-blue-500">
                                <div>
                                        <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                                                {{ $user->firstname }} {{ $user->lastname }}</h3>
                                        <p class="text-gray-600 dark:text-gray-400">@ {{ $user->name }}</p>
                                        <p class="mt-2 text-gray-800 dark:text-gray-200">
                                                {{ $user->profile->bio ?? 'No bio yet.' }}</p>

                                        @if(auth()->id() !== $user->id)
                                                <div class="mt-4">
                                                        @php
                                                                $friendship = auth()->user()->friends()->where('friend_id', $user->id)->first() ?? auth()->user()->friendsOf()->where('user_id', $user->id)->first();
                                                            @endphp

                                                        @if(!$friendship)
                                                                <form action="{{ route('friends.add', $user->id) }}" method="POST">
                                                                        @csrf
                                                                        <x-primary-button>Add Friend</x-primary-button>
                                                                </form>
                                                        @elseif($friendship->pivot->status === 'pending')
                                                                <span class="text-yellow-500">Friend Request Pending</span>
                                                        @else
                                                                <span class="text-green-500 font-bold">Friends</span>
                                                        @endif
                                                </div>
                                        @endif
                                </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @foreach($user->posts as $post)
                                        <div class="bg-white dark:bg-gray-800 p-6 shadow sm:rounded-lg">
                                                <p class="text-gray-800 dark:text-gray-200">{{ $post->content }}</p>
                                                @if($post->image)
                                                        <img src="{{ asset('storage/' . $post->image) }}"
                                                                class="mt-4 rounded-lg w-full">
                                                @endif
                                                <div class="mt-4 flex items-center justify-between text-sm text-gray-500">
                                                        <span>{{ $post->created_at->diffForHumans() }}</span>
                                                        <div class="flex space-x-4">
                                                                <span>👍 {{ $post->likes->count() }}</span>
                                                                <span>💬 {{ $post->comments->count() }}</span>
                                                        </div>
                                                </div>
                                        </div>
                                @endforeach
                        </div>
                </div>
        </div>
</x-app-layout>