@php

@endphp

<x-app-layout>
        <x-slot name="header">
                <div class="flex items-center space-x-4">
                        <a href="{{ route('dashboard') }}" class="p-2 rounded-full hover:bg-white/10 transition-colors">
                                <svg class="w-5 h-5 text-[#e7e9ea]" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                        </a>
                        <div>
                                <h2 class="font-bold text-xl text-[#e7e9ea] leading-tight">
                                        {{ $user->firstname }} {{ $user->lastname }}
                                </h2>
                                <p class="text-xs text-[#71767b]">{{ $user->posts->count() }} Posts</p>
                        </div>
                </div>
        </x-slot>

        <div class="max-w-4xl mx-auto border-x border-[#2f3336] min-h-screen bg-black">
                <!-- Banner -->
                <div class="h-48 bg-gradient-to-r from-[#1d9bf0] to-[#f91880] opacity-50 relative">
                </div>

                <!-- Profile Info -->
                <div class="px-4 pb-4">
                        <div class="relative flex justify-between items-end -mt-16 mb-4">
                                <div class="p-1 bg-black rounded-full">
                                        <img src="{{ $user->profile && $user->profile->avatar ? Storage::url($user->profile->avatar) : 'https://i.pravatar.cc/150?u=' . $user->id }}"
                                                class="w-32 h-32 rounded-full border-4 border-black object-cover">
                                </div>

                                @if(auth()->id() === $user->id)

                                <div class="flex flex-col gap-3">

                                        <a href="{{ route('profile.invite') }}" 
                                        class="btn btn-primary text-center">
                                        Générer lien d’invitation
                                        </a>

                                        <button id="showQrBtn" 
                                        class="px-4 py-2 rounded-full bg-indigo-600 text-white font-semibold hover:bg-indigo-700 transition">
                                        Afficher mon QR d’amitié
                                        </button>

                                        <div id="qrContainer"></div>

                                        <a href="{{ route('profile.edit') }}"
                                        class="px-4 py-2 rounded-full border border-[#2f3336] text-[#e7e9ea] font-bold text-sm hover:bg-white/10 transition-colors text-center">
                                        Edit profile
                                        </a>

                                        {{-- 🔥 Carte d'affichage du lien --}}
                                        @if(isset($link))
                                        <div class="mt-4 p-4 rounded-2xl bg-[#16181c] border border-[#2f3336] shadow-lg">
                                                
                                                <p class="text-sm text-gray-400 mb-2">
                                                🔗 Lien d’invitation (valide 1h)
                                                </p>

                                                <div class="flex items-center justify-between bg-black/40 px-3 py-2 rounded-lg">
                                                <span class="text-sm text-blue-400 truncate">
                                                        {{ $link }}
                                                </span>

                                                <button onclick="navigator.clipboard.writeText('{{ $link }}')"
                                                        class="ml-3 text-xs px-3 py-1 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                                                        Copier
                                                </button>
                                                </div>

                                        </div>
                                        @endif

                                </div>

                                @else


                                        <div class="mb-2">
                                               
                                                @php
                                                        $isFriend = auth()->user()->friends()->where('friend_id', $user->id)->exists() || auth()->user()->friendsOf()->where('user_id', $user->id)->exists();
                                                        $sentRequest = auth()->user()->sentFriendRequests()->where('receiver_id', $user->id)->exists();
                                                        $receivedRequest = auth()->user()->receivedFriendRequests()->where('sender_id', $user->id)->exists();
                                                @endphp

                                                @if($isFriend)
                                                        <button
                                                                class="px-4 py-2 rounded-full border border-[#2f3336] text-[#e7e9ea] font-bold text-sm hover:bg-red-500/10 hover:text-red-500 transition-colors group">
                                                                <span class="group-hover:hidden">Following</span>
                                                                <span class="hidden group-hover:inline">Unfollow</span>
                                                        </button>
                                                @elseif($sentRequest)
                                                        <span
                                                                class="px-4 py-2 rounded-full border border-[#2f3336] text-[#71767b] font-bold text-sm">
                                                                Requested
                                                        </span>
                                                @elseif($receivedRequest)
                                                        <form action="{{ route('friends.accept', $user->id) }}" method="POST"
                                                                class="inline">
                                                                @csrf
                                                                <button
                                                                        class="px-4 py-2 rounded-full bg-[#e7e9ea] text-black font-bold text-sm hover:bg-[#d7d9d9] transition-colors">
                                                                        Accept Request
                                                                </button>
                                                        </form>
                                                @else
                                                        <form action="{{ route('friends.add', $user->id) }}" method="POST"
                                                                class="inline">
                                                                @csrf
                                                                <button
                                                                        class="px-4 py-2 rounded-full bg-[#e7e9ea] text-black font-bold text-sm hover:bg-[#d7d9d9] transition-colors">
                                                                        Follow
                                                                </button>
                                                        </form>
                                                @endif
                                        </div>
                                @endif
                        </div>

                        <div class="space-y-1">
                                <h3 class="text-2xl font-black text-[#e7e9ea]">{{ $user->firstname }}
                                        {{ $user->lastname }}</h3>
                                <p class="text-[#71767b]">@ {{ $user->name }}</p>
                        </div>

                        <p class="mt-4 text-[#e7e9ea] text-[15px] leading-normal">
                                {{ $user->profile->bio ?? 'No bio yet. Linking up soon! 🚀' }}
                        </p>

                        <div class="mt-4 flex space-x-4 text-sm text-[#71767b]">
                                <div class="flex items-center space-x-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                        d="M19.708 2H4.292C3.028 2 2 3.028 2 4.292v15.416C2 20.972 3.028 22 4.292 22h15.416C20.972 22 22 20.972 22 19.708V4.292C22 3.028 20.972 2 19.708 2zm.792 17.708c0 .437-.355.792-.792.792H4.292a.792.792 0 01-.792-.792V4.292c0-.437.355-.792.792-.792h15.416c.437 0 .792.355.792.792v15.416z" />
                                        </svg>
                                        <span>Joined {{ $user->created_at->format('F Y') }}</span>
                                </div>
                        </div>

                        <div class="mt-4 flex space-x-4 text-sm">
                                <a href="#" class="hover:underline">
                                        <span
                                                class="font-bold text-[#e7e9ea]">{{ $user->friends()->count() + $user->friendsOf()->count() }}</span>
                                        <span class="text-[#71767b]">Following</span>
                                </a>
                                <a href="#" class="hover:underline">
                                        <span class="font-bold text-[#e7e9ea]">{{ $user->posts->count() }}</span>
                                        <span class="text-[#71767b]">Posts</span>
                                </a>
                        </div>
                </div>

                <!-- Tabs -->
                <div class="flex border-b border-[#2f3336]">
                        <button class="flex-1 py-4 text-[#e7e9ea] font-bold border-b-4 border-[#1d9bf0]">Posts</button>
                        <button
                                class="flex-1 py-4 text-[#71767b] font-medium hover:bg-white/5 transition-colors">Replies</button>
                        <button
                                class="flex-1 py-4 text-[#71767b] font-medium hover:bg-white/5 transition-colors">Media</button>
                        <button
                                class="flex-1 py-4 text-[#71767b] font-medium hover:bg-white/5 transition-colors">Likes</button>
                </div>

                <!-- Feed -->
                <div class="p-4">
                        @include('components.post-list', ['posts' => $user->posts])
                </div>
        </div>

        <script>
                document.getElementById('showQrBtn').addEventListener('click', function() {
                fetch('/my-qr')
                        .then(response => response.json())
                        .then(data => {
                        document.getElementById('qrContainer').innerHTML = data.qr;
                        });
                });
        </script>
</x-app-layout>