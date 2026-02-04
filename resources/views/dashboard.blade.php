<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl tracking-tight text-[#e7e9ea]">
                {{ __('Home') }}
            </h2>
            <div class="flex items-center space-x-2">
                <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                <span class="text-xs text-[#71767b] font-medium uppercase tracking-widest">Live Feed</span>
            </div>
        </div>
    </x-slot>

    <div class="grid grid-cols-12 gap-6 relative">
        <!-- LEFT SIDEBAR -->
        <aside class="hidden lg:block lg:col-span-3 space-y-6">
            <div class="glass-card p-6 text-center group">
                <div class="relative inline-block mb-4">
                    <div
                        class="absolute -inset-1 bg-gradient-to-r from-[#1d9bf0] to-[#f91880] rounded-full blur opacity-25 group-hover:opacity-50 transition duration-1000 group-hover:duration-200">
                    </div>
                    <img src="{{ auth()->user()->profile && auth()->user()->profile->avatar ? asset('storage/' . auth()->user()->profile->avatar) : 'https://i.pravatar.cc/150?u=' . auth()->id() }}"
                        class="w-32 h-32 rounded-full object-cover shadow-lg border-2 border-white">
                </div>
                <h3 class="font-bold text-xl text-[#e7e9ea]">{{ auth()->user()->firstname }}
                    {{ auth()->user()->lastname }}</h3>
                <p class="text-[#71767b] text-sm mb-6 mt-1 tracking-tight">@ {{ auth()->user()->name }}</p>

                <div class="grid grid-cols-2 gap-4 border-t border-[#2f3336] pt-6">
                    <div class="text-center">
                        <span
                            class="block font-bold text-[#e7e9ea] text-lg">{{ auth()->user()->friends()->count() }}</span>
                        <span class="text-xs text-[#71767b] uppercase tracking-wider">Friends</span>
                    </div>
                    <div class="text-center">
                        <span
                            class="block font-bold text-[#e7e9ea] text-lg">{{ auth()->user()->posts()->count() }}</span>
                        <span class="text-xs text-[#71767b] uppercase tracking-wider">Posts</span>
                    </div>
                </div>

                <a href="{{ route('profile.edit') }}"
                    class="mt-6 block w-full py-2.5 rounded-xl border border-[#2f3336] text-sm font-bold text-[#e7e9ea] hover:bg-[#1d9bf0]/10 hover:border-[#1d9bf0] transition-all">
                    Settings
                </a>
            </div>

            <!-- TRENDS / STATS -->
            <div class="glass-card p-4">
                <h3 class="font-bold text-[#e7e9ea] mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-[#1d9bf0]" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M12 2c5.514 0 10 4.486 10 10s-4.486 10-10 10-10-4.486-10-10 4.486-10 10-10zm0-2c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm.25 12h-3.25l4-5v3.25h3.25l-4 5v-3.25z" />
                    </svg>
                    Trending for you
                </h3>
                <div class="space-y-4">
                    <div class="group cursor-pointer">
                        <p class="text-[#71767b] text-xs">Trending in Tech</p>
                        <p class="font-bold text-[#e7e9ea] group-hover:underline">#Laravel12</p>
                        <p class="text-[#71767b] text-xs">2.4K posts</p>
                    </div>
                    <div class="group cursor-pointer">
                        <p class="text-[#71767b] text-xs">Social</p>
                        <p class="font-bold text-[#e7e9ea] group-hover:underline">#LinkUpConnect</p>
                        <p class="text-[#71767b] text-xs">1.8K posts</p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- FEED CENTER -->
        <main class="col-span-12 lg:col-span-6 space-y-6">
            <!-- Create Post Box -->
            <div class="glass-card p-5">
                <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="flex gap-4">
                        <img src="{{ auth()->user()->profile && auth()->user()->profile->avatar ? asset(auth()->user()->profile->avatar) : 'https://i.pravatar.cc/150?u=' . auth()->id() }}"
                            class="w-12 h-12 rounded-full object-cover border">
                        <div class="flex-1">
                            <textarea name="content" placeholder="What's happening?"
                                class="w-full bg-transparent text-xl text-[#e7e9ea] border-none focus:ring-0 placeholder-[#71767b] resize-none"
                                rows="3" required></textarea>
                            <div id="image-preview" class="mt-4 hidden relative">
                                <img src=""
                                    class="rounded-2xl max-h-80 w-full object-cover border border-[#2f3336]">
                                <button type="button" onclick="clearImage()"
                                    class="absolute top-2 right-2 bg-black/50 p-1.5 rounded-full text-white hover:bg-black/70">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-between items-center mt-4 pt-4 border-t border-[#2f3336]">
                        <div class="flex space-x-2">
                            <label
                                class="p-2 rounded-full text-[#1d9bf0] hover:bg-[#1d9bf0]/10 cursor-pointer transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M3 5.5C3 4.119 4.119 3 5.5 3h13C19.881 3 21 4.119 21 5.5v13c0 1.381-1.119 2.5-2.5 2.5h-13C4.119 21 3 19.881 3 18.5v-13zM5.5 5c-.276 0-.5.224-.5.5v9.086l3-3 3 3 5-5 3 3V5.5c0-.276-.224-.5-.5-.5h-13zM19 15.414l-3-3-5 5-3-3-3 3V18.5c0 .276.224.5.5.5h13c.276 0 .5-.224.5-.5v-3.086zM9.75 7C8.784 7 8 7.784 8 8.75s.784 1.75 1.75 1.75 1.75-.784 1.75-1.75S10.716 7 9.75 7z" />
                                </svg>
                                <input type="file" name="image" class="hidden" accept="image/*"
                                    onchange="previewImage(this)">
                            </label>
                            <button type="button"
                                class="p-2 rounded-full text-[#1d9bf0] hover:bg-[#1d9bf0]/10 transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M19 10.5V8.8h-4.4c-.4 0-.8.3-.8.8v7.6c0 .4.3.8.8.8H19v-1.7h-3.4v-2.1h2.5v-1.7h-2.5v-2h3.4zM5 13H4V4h11v9h-1V5H5v8zm2 5h1v-5H6v5h1zm2.5 0h1v-3.5h1V13h-3v1.5h1V18zm5 0h1v-5h-1v5z" />
                                </svg>
                            </button>
                        </div>
                        <button type="submit" class="btn-vibrant">Post</button>
                    </div>
                </form>
            </div>

            <!-- Posts List -->
            @forelse ($posts as $post)
                <div
                    class="glass-card hover:bg-[#1c1f23] transition-colors border-l-4 {{ $loop->first ? 'border-l-[#1d9bf0]' : 'border-l-transparent' }}">
                    <div class="p-5">
                        <div class="flex justify-between items-start">
                            <div class="flex items-center gap-3">
                                <div class="relative">
                                    <img src="{{ $post->user->profile && $post->user->profile->avatar ? asset('storage/' . $post->user->profile->avatar) : 'https://i.pravatar.cc/48?u=' . $post->user->id }}"
                                        class="w-12 h-12 rounded-full border border-[#2f3336] object-cover">
                                    <div
                                        class="absolute -bottom-1 -right-1 w-4 h-4 rounded-full border-2 border-black bg-green-500">
                                    </div>
                                </div>
                                <div>
                                    <div class="flex items-center gap-1">
                                        <a href="{{ route('profile.show', $post->user->id) }}"
                                            class="font-bold text-[#e7e9ea] hover:underline">{{ $post->user->name }}</a>
                                        @if ($post->user->id == 1)
                                            <!-- Example admin verify -->
                                            <svg class="w-4 h-4 text-[#1d9bf0]" fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M22.5 12.5c0-1.58-.88-2.95-2.18-3.66.15-.44.23-.91.23-1.4 0-2.45-1.99-4.44-4.44-4.44-.49 0-.96.08-1.4.23-1.41-1.3-3.23-2.18-5.26-2.18-2.03 0-3.85.88-5.26 2.18-.44-.15-.91-.23-1.4-.23-2.45 0-4.44 1.99-4.44 4.44 0 .49.08.91.23 1.4-1.3.71-2.18 2.08-2.18 3.66 0 1.58.88 2.95 2.18 3.66-.15.44-.23.91-.23 1.4 0 2.45 1.99 4.44 4.44 4.44.49 0 .96-.08 1.4-.23 1.41 1.3 3.23 2.18 5.26 2.18 2.03 0 3.85-.88 5.26-2.18.44.15.91.23 1.4.23 2.45 0 4.44-1.99 4.44-4.44 0-.49-.08-.91-.23-1.4 1.3-.71 2.18-2.08 2.18-3.66zM10.29 16.72L6.5 12.93l1.41-1.41 2.38 2.38 5.72-5.72 1.41 1.41-7.13 7.13z" />
                                            </svg>
                                        @endif
                                    </div>
                                    <p class="text-xs text-[#71767b]">{{ $post->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            @if ($post->owner_id === auth()->id())
                                <x-dropdown align="right" width="48">
                                    <x-slot name="trigger">
                                        <button
                                            class="text-[#71767b] hover:text-[#1d9bf0] p-1 rounded-full hover:bg-[#1d9bf0]/10">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M3 12a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0zm7.5 0a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0zm7.5 0a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0z" />
                                            </svg>
                                        </button>
                                    </x-slot>
                                    <x-slot name="content">
                                        <form action="{{ route('posts.destroy', $post) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <x-dropdown-link href="#"
                                                onclick="event.preventDefault(); this.closest('form').submit();"
                                                class="text-red-500">
                                                Delete Post
                                            </x-dropdown-link>
                                            {{-- @csrf @method('UPDATE') --}}
                                            {{-- <x-dropdown-link href="#"
                                                onclick="event.preventDefault(); this.closest('form').submit();"
                                                class="text-green-500">
                                                Update Post
                                            </x-dropdown-link> --}}
                                        </form>
                                    </x-slot>
                                </x-dropdown>
                            @endif
                        </div>

                        <div class="mt-4 text-[#e7e9ea] leading-relaxed">
                            <p class="whitespace-pre-wrap">{{ $post->content }}</p>
                        </div>
                    </div>

                    @if ($post->image)
                        <div class="px-5 pb-4">
                            <img src="{{ asset('storage/' . $post->image) }}"
                                class="rounded-2xl w-full max-h-[512px] object-cover border border-[#2f3336]">
                        </div>
                    @endif

                    <!-- Interactions -->
                    <div class="px-5 py-3 border-t border-[#2f3336] flex items-center justify-between">
                        <div class="flex items-center space-x-8">
                            <form action="{{ route('posts.react', $post) }}" method="POST">
                                @csrf
                                <button
                                    class="group flex items-center gap-2 transition {{ $post->likes->where('user_id', auth()->id())->count() ? 'text-[#f91880]' : 'text-[#71767b]' }}">
                                    <div class="p-2 rounded-full group-hover:bg-[#f91880]/10 transition-colors">
                                        <svg class="w-5 h-5"
                                            fill="{{ $post->likes->where('user_id', auth()->id())->count() ? 'currentColor' : 'none' }}"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                        </svg>
                                    </div>
                                    <span class="text-sm font-medium">{{ $post->likes->count() }}</span>
                                </button>
                            </form>

                            <button onclick="toggleComments({{ $post->id }})"
                                class="group flex items-center gap-2 text-[#71767b] hover:text-[#1d9bf0] transition">
                                <div class="p-2 rounded-full group-hover:bg-[#1d9bf0]/10 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                </div>
                                <span class="text-sm font-medium">{{ $post->comments->count() }}</span>
                            </button>
                        </div>

                        <button
                            class="p-2 rounded-full text-[#71767b] hover:bg-[#1d9bf0]/10 hover:text-[#1d9bf0] transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                            </svg>
                        </button>
                    </div>

                    <!-- Comments Section -->
                    <div id="comments-{{ $post->id }}"
                        class="hidden px-5 py-4 bg-black/20 border-t border-[#2f3336]">
                        <div class="space-y-4">
                            @foreach ($post->comments as $comment)
                                <div class="flex items-start gap-3">
                                    <img src="{{ $comment->user->profile && $comment->user->profile->avatar ? asset('storage/' . $comment->user->profile->avatar) : 'https://i.pravatar.cc/32?u=' . $comment->user->id }}"
                                        class="w-8 h-8 rounded-full border border-[#2f3336]">
                                    <div class="flex-1 bg-[#202327] rounded-2xl px-4 py-2">
                                        <div class="flex items-center justify-between">
                                            <p class="text-sm font-bold text-[#e7e9ea]">{{ $comment->user->name }}</p>
                                            <span
                                                class="text-[11px] text-[#71767b]">{{ $comment->created_at->shortRelativeDiffForHumans() }}</span>
                                        </div>
                                        <p class="text-sm text-[#e7e9ea] mt-0.5">{{ $comment->content }}</p>
                                    </div>
                                </div>
                            @endforeach

                            <form action="{{ route('comments.store', $post) }}" method="POST"
                                class="flex items-center gap-3 mt-4">
                                @csrf
                                <img src="{{ auth()->user()->profile && auth()->user()->profile->avatar ? asset('storage/' . auth()->user()->profile->avatar) : 'https://i.pravatar.cc/32?u=' . auth()->id() }}"
                                    class="w-8 h-8 rounded-full border border-[#2f3336]">
                                <input type="text" name="content" placeholder="Post your reply"
                                    class="flex-1 bg-[#202327] border-none rounded-full px-4 py-2 text-sm text-[#e7e9ea] focus:ring-1 focus:ring-[#1d9bf0]"
                                    required>
                                <button type="submit" class="text-[#1d9bf0] font-bold text-sm px-2">Reply</button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="glass-card p-10 text-center">
                    <div class="w-20 h-20 bg-[#1d9bf0]/10 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-[#1d9bf0]" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-[#e7e9ea]">Welcome to your feed!</h4>
                    <p class="text-[#71767b] mt-2 mb-6">Start following people to see their latest updates here.</p>
                    <a href="{{ route('friends.page') }}" class="btn-vibrant inline-block">Find Friends</a>
                </div>
            @endforelse

            <!-- Pagination -->
            <div class="mt-6">
                {{ $posts->links() }}
            </div>
        </main>

        <!-- RIGHT SIDEBAR -->
        <aside class="hidden lg:block lg:col-span-3 space-y-6">
            <div class="glass-card sticky top-24">
                <div class="p-4 border-b border-[#2f3336]">
                    <h3 class="font-bold text-xl text-[#e7e9ea]">Who to follow</h3>
                </div>
                <div class="p-4 space-y-4">
                    @php
                        $suggestions = App\Models\User::where('id', '!=', auth()->id())
                            ->limit(5)
                            ->get();
                    @endphp
                    @foreach ($suggestions as $user)
                        <div class="flex items-center justify-between group">
                            <div class="flex items-center gap-3">
                                <img src="{{ $user->profile && $user->profile->avatar ? asset('storage/' . $user->profile->avatar) : 'https://i.pravatar.cc/40?u=' . $user->id }}"
                                    class="w-10 h-10 rounded-full border border-[#2f3336] object-cover transition transform group-hover:scale-110">
                                <div class="flex flex-col">
                                    <a href="{{ route('profile.show', $user->id) }}"
                                        class="font-bold text-sm text-[#e7e9ea] hover:underline truncate max-w-[100px]">{{ $user->name }}</a>
                                    <span class="text-xs text-[#71767b]">@ {{ Str::slug($user->name) }}</span>
                                </div>
                            </div>
                            <form action="{{ route('friends.add', $user->id) }}" method="POST">
                                @csrf
                                <button
                                    class="bg-[#e7e9ea] text-black text-xs font-bold py-1.5 px-4 rounded-full hover:bg-[#d7d9d9] transition-colors">
                                    Follow
                                </button>
                            </form>
                        </div>
                    @endforeach
                    <a href="{{ route('friends.page') }}"
                        class="block text-[#1d9bf0] text-sm py-2 hover:bg-[#1d9bf0]/5 rounded-lg transition-colors">Show
                        more</a>
                </div>
            </div>

            <div class="px-4 text-[13px] text-[#71767b] space-x-2">
                <a href="#" class="hover:underline">Terms of Service</a>
                <a href="#" class="hover:underline">Privacy Policy</a>
                <a href="#" class="hover:underline">Cookie Policy</a>
                <p class="mt-2">© 2026 LinkUp Corp.</p>
            </div>
        </aside>
    </div>

    @push('scripts')
        <script>
            function previewImage(input) {
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const preview = document.getElementById('image-preview');
                        preview.querySelector('img').src = e.target.result;
                        preview.classList.remove('hidden');
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }

            function clearImage() {
                const input = document.querySelector('input[name="image"]');
                input.value = '';
                document.getElementById('image-preview').classList.add('hidden');
            }

            function toggleComments(postId) {
                const el = document.getElementById(`comments-${postId}`);
                el.classList.toggle('hidden');
            }
        </script>
    @endpush
</x-app-layout>
