@foreach($posts as $post)
    <div class="glass-card p-4 mb-6 animate-fade-in">
        <div class="flex gap-4">
            <a href="{{ route('profile.show', $post->user->id) }}" class="flex-shrink-0">
                <img src="{{ $post->user->profile && $post->user->profile->avatar ? Storage::url($post->user->profile->avatar) : 'https://i.pravatar.cc/150?u=' . $post->user->id }}"
                    class="w-12 h-12 rounded-full object-cover border border-[#2f3336] hover:opacity-80 transition-opacity">
            </a>
            <div class="flex-1 min-w-0">
                <div class="flex items-center justify-between">
                    <div>
                        <a href="{{ route('profile.show', $post->user->id) }}"
                            class="font-bold text-[#e7e9ea] hover:underline">
                            {{ $post->user->firstname }} {{ $post->user->lastname }}
                        </a>
                        <span class="text-[#71767b] text-sm ml-1">@ {{ $post->user->name }} ·
                            {{ $post->created_at->diffForHumans() }}</span>
                    </div>
                </div>

                <p class="mt-2 text-[#e7e9ea] text-[15px] leading-normal whitespace-pre-wrap">{{ $post->content }}</p>

                @if($post->image)
                    <div class="mt-3 rounded-2xl overflow-hidden border border-[#2f3336]">
                        <img src="{{ Storage::url($post->image) }}" class="w-full object-cover max-h-[500px]">
                    </div>
                @endif

                <div class="mt-4 flex items-center justify-between max-w-md">
                    <!-- Like Button -->
                    <form action="{{ route('posts.react', $post->id)}}" method="POST" class="inline">
                        @csrf
                        <button type="submit"
                            class="flex items-center space-x-2 group text-[#71767b] hover:text-[#f91880] transition-colors">
                            <div class="p-2 rounded-full group-hover:bg-[#f91880]/10 transition-colors">
                                @php
                                    $hasLiked = $post->likes->contains('user_id', auth()->id());
                                @endphp
                                @if($hasLiked)
                                    <svg class="w-5 h-5 text-[#f91880]" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M20.884 13.19c-1.351 2.48-4.001 5.12-8.379 7.67l-.505.3-.505-.3c-4.377-2.55-7.027-5.19-8.379-7.67-1.36-2.5-1.41-4.86-.514-6.67.887-1.79 2.647-2.91 4.601-3.01 1.651-.09 3.368.56 4.798 2.01 1.429-1.45 3.146-2.1 4.796-2.01 1.954.1 3.714 1.22 4.601 3.01.896 1.81.846 4.17-.514 6.67z" />
                                    </svg>
                                @else
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                @endif
                            </div>
                            <span
                                class="text-sm font-medium {{ $hasLiked ? 'text-[#f91880]' : '' }}">{{ $post->likes->count() ?: '' }}</span>
                        </button>
                    </form>

                    <!-- Comment Button -->
                    <button onclick="toggleComments({{ $post->id }})"
                        class="flex items-center space-x-2 group text-[#71767b] hover:text-[#1d9bf0] transition-colors">
                        <div class="p-2 rounded-full group-hover:bg-[#1d9bf0]/10 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                        </div>
                        <span class="text-sm font-medium">{{ $post->comments->count() ?: '' }}</span>
                    </button>

                    <!-- Share Button (Decorative) -->
                    <button class="flex items-center space-x-2 group text-[#71767b] hover:text-[#00ba7c] transition-colors">
                        <div class="p-2 rounded-full group-hover:bg-[#00ba7c]/10 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                            </svg>
                        </div>
                    </button>
                </div>

                <!-- Comments Section -->
                <div id="comments-{{ $post->id }}" class="hidden mt-4 pt-4 border-t border-[#2f3336]">
                    <div class="space-y-4 max-h-60 overflow-y-auto pr-2 scrollbar-hide">
                        @foreach($post->comments as $comment)
                            <div class="flex items-start space-x-3">
                                <img src="{{ $comment->user->profile && $comment->user->profile->avatar ? Storage::url($comment->user->profile->avatar) : 'https://i.pravatar.cc/150?u=' . $comment->user->id }}"
                                    class="w-8 h-8 rounded-full object-cover">
                                <div class="bg-[#202327] rounded-2xl p-3 flex-1">
                                    <div class="flex items-center justify-between">
                                        <span class="font-bold text-[#e7e9ea] text-sm">{{ $comment->user->name }}</span>
                                        <span class="text-[#71767b] text-xs">{{ $comment->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-[#e7e9ea] text-sm mt-1">{{ $comment->content }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Add Comment -->
                    <form action="{{ route('comments.store', $post->id) }}" method="POST" class="mt-4 flex gap-2">
                        @csrf
                        <input type="text" name="content" placeholder="Post your reply"
                            class="flex-1 bg-[#202327] border-none rounded-full py-2 px-4 text-sm text-[#e7e9ea] focus:ring-1 focus:ring-[#1d9bf0]">
                        <button type="submit"
                            class="text-[#1d9bf0] font-bold text-sm px-4 hover:bg-[#1d9bf0]/10 rounded-full transition-colors">
                            Reply
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach