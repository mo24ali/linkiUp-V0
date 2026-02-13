<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl tracking-tight text-[#e7e9ea]">
                {{ __('Home') }}
            </h2>

            <form action="{{ route('dashboard') }}" method="GET" class="relative mx-4 flex-1 max-w-md hidden md:block">
                <input type="text" name="search" placeholder="Search posts..." value="{{ request('search') }}"
                    class="w-full bg-[#202327] border-none rounded-full py-2 px-10 text-[#e7e9ea] focus:ring-1 focus:ring-[#1d9bf0] text-sm">
                <svg class="w-4 h-4 text-[#71767b] absolute left-3 top-1/2 transform -translate-y-1/2" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </form>

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
                    <img src="{{ auth()->user()->profile && auth()->user()->profile->avatar ? Storage::url(auth()->user()->profile->avatar) : 'https://i.pravatar.cc/150?u=' . auth()->id() }}"
                        class="w-32 h-32 rounded-full object-cover shadow-lg border-2 border-white">
                </div>
                <h3 class="font-bold text-xl text-[#e7e9ea]">{{ auth()->user()->firstname }}
                    {{ auth()->user()->lastname }}
                </h3>
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
            <!-- Stories Section -->
            <div class="glass-card p-4">
                <h3 class="font-bold text-[#e7e9ea] mb-3 text-sm">Stories</h3>
                <div class="flex space-x-4 overflow-x-auto pb-2 scrollbar-hide">
                    <!-- Add Story Form -->
                    <form action="{{ route('stories.store') }}" method="POST" enctype="multipart/form-data"
                        class="flex-shrink-0 text-center">
                        @csrf
                        <label
                            class="block w-16 h-16 rounded-full border-2 border-dashed border-[#1d9bf0] flex items-center justify-center hover:bg-[#1d9bf0]/10 cursor-pointer transition group">
                            <svg class="w-6 h-6 text-[#1d9bf0] group-hover:scale-110 transition-transform"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                            <input type="file" name="image" class="hidden" onchange="this.form.submit()">
                        </label>
                        <span class="text-xs mt-1 block text-[#71767b]">Your Story</span>
                    </form>

                    @isset($stories)
                        @foreach ($stories as $story)
                            <div class="flex-shrink-0 text-center w-16 group cursor-pointer"
                                onclick="viewStory('{{ Storage::url($story->image_path) }}', '{{ $story->user->name }}', '{{ $story->user->profile && $story->user->profile->avatar ? Storage::url($story->user->profile->avatar) : 'https://i.pravatar.cc/150?u=' . $story->user->id }}')">
                                <div
                                    class="w-16 h-16 rounded-full ring-2 ring-[#1d9bf0] p-0.5 group-hover:ring-[#f91880] transition-all">
                                    <img src="{{ $story->user->profile && $story->user->profile->avatar ? Storage::url($story->user->profile->avatar) : 'https://i.pravatar.cc/150?u=' . $story->user->id }}"
                                        class="w-full h-full rounded-full object-cover">
                                </div>
                                <span
                                    class="text-xs mt-1 block truncate text-[#e7e9ea] max-w-full font-medium">{{ $story->user->name }}</span>
                            </div>
                        @endforeach
                    @endisset
                </div>
            </div>

            <!-- Create Post Box -->
            <div class="glass-card p-5">
                <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="flex gap-4">
                        <img src="{{ auth()->user()->profile && auth()->user()->profile->avatar ? Storage::url(auth()->user()->profile->avatar) : 'https://i.pravatar.cc/150?u=' . auth()->id() }}"
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

            <!-- Posts List Container -->
            <div id="posts-container">
                @include('components.post-list')

            </div>

            <!-- Loading Spinner -->
            <div id="loading" class="hidden text-center py-4">
                <svg class="animate-spin h-6 w-6 text-[#1d9bf0] mx-auto" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
            </div>

            <script>
                let page = 1;
                let loading = false;
                window.onscroll = function(ev) {
                    if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight - 500) {
                        if (!loading) {
                            loading = true;
                            page++;
                            loadMoreData(page);
                        }
                    }
                };

                function loadMoreData(page) {
                    document.getElementById('loading').classList.remove('hidden');
                    fetch('?page=' + page, {
                            headers: {
                                "X-Requested-With": "XMLHttpRequest"
                            }
                        })
                        .then(response => response.text())
                        .then(html => {
                            document.getElementById('loading').classList.add('hidden');
                            if (html.trim() == "") {
                                return;
                            }
                            const container = document.getElementById('posts-container');
                            container.insertAdjacentHTML('beforeend', html);
                            loading = false;
                        })
                        .catch(() => {
                            document.getElementById('loading').classList.add('hidden');
                            loading = false;
                        });
                }
            </script>
        </main>

        <!-- RIGHT SIDEBAR -->
        <aside class="hidden lg:block lg:col-span-3 space-y-6">
            <div class="glass-card sticky top-24">
                <div class="p-4 border-b border-[#2f3336]">
                    <h3 class="font-bold text-xl text-[#e7e9ea]">Who to follow</h3>
                </div>
                <div class="p-4 space-y-4">
                    @isset($suggestions)
                        @foreach ($suggestions as $user)
                            <div class="flex items-center justify-between group">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $user->profile && $user->profile->avatar ? Storage::url($user->profile->avatar) : 'https://i.pravatar.cc/40?u=' . $user->id }}"
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
                    @endisset
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

            function viewStory(imgUrl, name, avatar) {
                const viewer = document.getElementById('story-viewer');
                document.getElementById('story-img').src = imgUrl;
                document.getElementById('story-author-name').innerText = name;
                document.getElementById('story-author-img').src = avatar;
                viewer.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }

            function closeStory() {
                const viewer = document.getElementById('story-viewer');
                viewer.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }

            function editPost(id, content) {
                document.getElementById(`post-content-${id}`).classList.add('hidden');
                document.getElementById(`post-edit-${id}`).classList.remove('hidden');
            }

            function cancelEditPost(id) {
                document.getElementById(`post-content-${id}`).classList.remove('hidden');
                document.getElementById(`post-edit-${id}`).classList.add('hidden');
            }

            function editComment(id, content) {
                document.getElementById(`comment-content-${id}`).classList.add('hidden');
                document.getElementById(`comment-edit-${id}`).classList.remove('hidden');
            }

            function cancelEditComment(id) {
                document.getElementById(`comment-content-${id}`).classList.remove('hidden');
                document.getElementById(`comment-edit-${id}`).classList.add('hidden');
            }
        </script>
    @endpush

    <!-- Story Viewer Modal -->
    <div id="story-viewer" class="fixed inset-0 z-[100] hidden bg-black flex items-center justify-center">
        <button onclick="closeStory()"
            class="absolute top-6 right-6 text-white p-2 hover:bg-white/10 rounded-full z-[110]">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        <div class="relative max-w-md w-full h-[90vh] bg-[#15181c] md:rounded-2xl overflow-hidden shadow-2xl">
            <div
                class="absolute top-0 left-0 right-0 p-4 bg-gradient-to-b from-black/80 to-transparent flex items-center gap-3 z-10">
                <img id="story-author-img" src="" class="w-10 h-10 rounded-full border border-white/20">
                <span id="story-author-name" class="text-white font-bold shadow-sm"></span>
            </div>
            <img id="story-img" src="" class="w-full h-full object-cover">
        </div>
    </div>
</x-app-layout>
