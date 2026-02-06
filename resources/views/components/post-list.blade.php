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

                    @if($post->owner_id === auth()->id())
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="text-[#71767b] hover:text-[#1d9bf0] p-2 rounded-full hover:bg-[#1d9bf0]/10 transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/>
                            </svg>
                        </button>
                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-[#15181c] border border-[#2f3336] rounded-xl shadow-xl z-50 py-2">
                            <button onclick="editPost({{ $post->id }}, '{{ addslashes($post->content) }}')" class="w-full text-left px-4 py-2 text-sm text-[#e7e9ea] hover:bg-[#2f3336] flex items-center">
                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                Edit Post
                            </button>
                            <form action="{{ route('posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-[#f91880] hover:bg-[#f91880]/10 flex items-center">
                                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    Delete Post
                                </button>
                            </form>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Post Content / Edit Form -->
                <div id="post-content-{{ $post->id }}">
                    <p class="mt-2 text-[#e7e9ea] text-[15px] leading-normal whitespace-pre-wrap">{{ $post->content }}</p>
                </div>
                <div id="post-edit-{{ $post->id }}" class="hidden mt-2">
                    <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <textarea name="content" class="w-full bg-[#15181c] border-[#2f3336] rounded-xl text-white text-sm focus:ring-[#1d9bf0]" rows="3">{{ $post->content }}</textarea>
                        <div class="flex justify-end gap-2 mt-2">
                            <button type="button" onclick="cancelEditPost({{ $post->id }})" class="text-xs text-[#71767b] hover:underline">Cancel</button>
                            <button type="submit" class="btn-vibrant py-1 px-4 text-xs">Save</button>
                        </div>
                    </form>
                </div>

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
                                    $hasLiked = $post->likes->isNotEmpty();
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
                                class="text-sm font-medium {{ $hasLiked ? 'text-[#f91880]' : '' }}">{{ $post->likes_count ?: '' }}</span>
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
                        <span class="text-sm font-medium">{{ $post->comments_count ?: '' }}</span>
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
                    <div class="space-y-4 max-h-80 overflow-y-auto pr-2 scrollbar-hide">
                        @foreach($post->comments as $comment)
                            <div class="flex items-start space-x-3 group/comment">
                                <img src="{{ $comment->user->profile && $comment->user->profile->avatar ? Storage::url($comment->user->profile->avatar) : 'https://i.pravatar.cc/150?u=' . $comment->user->id }}"
                                    class="w-8 h-8 rounded-full object-cover">
                                <div class="bg-[#202327] rounded-2xl p-3 flex-1">
                                    <div class="flex items-center justify-between">
                                        <span class="font-bold text-[#e7e9ea] text-sm">{{ $comment->user->name }}</span>
                                        <div class="flex items-center space-x-2">
                                            <span class="text-[#71767b] text-xs">{{ $comment->created_at->diffForHumans() }}</span>
                                            
                                            <!-- Comment Actions Dropdown/Buttons -->
                                            @if($comment->poster_id === auth()->id())
                                            <div class="flex opacity-0 group-hover/comment:opacity-100 transition-opacity">
                                                <button onclick="editComment({{ $comment->id }}, '{{ addslashes($comment->content) }}')" class="text-[#71767b] hover:text-[#1d9bf0] p-1">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                                </button>
                                                <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" onsubmit="return confirm('Delete comment?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-[#71767b] hover:text-[#f91880] p-1">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    </button>
                                                </form>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div id="comment-content-{{ $comment->id }}">
                                        <p class="text-[#e7e9ea] text-sm mt-1">{{ $comment->content }}</p>
                                    </div>
                                    <div id="comment-edit-{{ $comment->id }}" class="hidden mt-1">
                                        <form action="{{ route('comments.update', $comment->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="text" name="content" value="{{ $comment->content }}" class="w-full bg-[#15181c] border-[#2f3336] rounded-xl text-white text-xs py-1 px-2 focus:ring-[#1d9bf0]">
                                            <div class="flex justify-end gap-2 mt-1">
                                                <button type="button" onclick="cancelEditComment({{ $comment->id }})" class="text-[10px] text-[#71767b] hover:underline">Cancel</button>
                                                <button type="submit" class="text-[10px] text-[#1d9bf0] font-bold">Save</button>
                                            </div>
                                        </form>
                                    </div>

                                    <!-- Comment Footer: Likes & Reply -->
                                    <div class="flex items-center space-x-4 mt-2">
                                        <form action="{{ route('comments.react', $comment->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="flex items-center space-x-1 text-xs group/like">
                                                @php $commentLiked = $comment->likes->isNotEmpty(); @endphp
                                                <svg class="w-3.5 h-3.5 {{ $commentLiked ? 'text-[#f91880]' : 'text-[#71767b] group-hover/like:text-[#f91880]' }}" fill="{{ $commentLiked ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                                </svg>
                                                <span class="{{ $commentLiked ? 'text-[#f91880]' : 'text-[#71767b]' }}">{{ $comment->likes_count ?: 0 }}</span>
                                            </button>
                                        </form>
                                        <button onclick="document.getElementById('reply-form-{{ $comment->id }}').classList.toggle('hidden')" class="text-xs text-[#71767b] hover:text-[#1d9bf0] font-medium">
                                            Reply
                                        </button>
                                    </div>

                                    <!-- Reply Form -->
                                    <div id="reply-form-{{ $comment->id }}" class="hidden mt-2">
                                        <form action="{{ route('comments.store', $post->id) }}" method="POST" class="flex gap-2">
                                            @csrf
                                            <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                            <input type="text" name="content" placeholder="Reply to {{ $comment->user->name }}..." class="flex-1 bg-[#15181c] border-[#2f3336] rounded-full py-1 px-3 text-xs text-[#e7e9ea] focus:ring-[#1d9bf0]">
                                            <button type="submit" class="text-[#1d9bf0] text-xs font-bold px-2">Post</button>
                                        </form>
                                    </div>

                                    <!-- Nested Replies -->
                                    @if($comment->replies->count() > 0)
                                        <div class="mt-2 space-y-2 border-l-2 border-[#2f3336] pl-3 ml-1">
                                            @foreach($comment->replies as $reply)
                                                <div class="flex items-start space-x-2 group/reply">
                                                    <img src="{{ $reply->user->profile && $reply->user->profile->avatar ? Storage::url($reply->user->profile->avatar) : 'https://i.pravatar.cc/150?u=' . $reply->user->id }}"
                                                        class="w-6 h-6 rounded-full object-cover">
                                                    <div class="flex-1">
                                                        <div class="bg-[#15181c] rounded-xl p-2">
                                                            <div class="flex justify-between items-center">
                                                                <span class="font-bold text-[#e7e9ea] text-xs">{{ $reply->user->name }}</span>
                                                                <span class="text-[#71767b] text-[10px]">{{ $reply->created_at->diffForHumans() }}</span>
                                                            </div>
                                                            <p class="text-[#e7e9ea] text-xs mt-0.5">{{ $reply->content }}</p>
                                                        </div>
                                                        <div class="flex items-center space-x-3 mt-1 ml-1">
                                                             <form action="{{ route('comments.react', $reply->id) }}" method="POST">
                                                                @csrf
                                                                <button type="submit" class="flex items-center space-x-1 text-[10px] group/rlike">
                                                                    @php $replyLiked = $reply->likes->isNotEmpty(); @endphp
                                                                    <svg class="w-3 h-3 {{ $replyLiked ? 'text-[#f91880]' : 'text-[#71767b] group-hover/rlike:text-[#f91880]' }}" fill="{{ $replyLiked ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                                                    </svg>
                                                                    <span class="{{ $replyLiked ? 'text-[#f91880]' : 'text-[#71767b]' }}">{{ $reply->likes_count ?: 0 }}</span>
                                                                </button>
                                                            </form>
                                                            @if($reply->poster_id === auth()->id())
                                                                <form action="{{ route('comments.destroy', $reply->id) }}" method="POST" onsubmit="return confirm('Delete reply?')" class="opacity-0 group-hover/reply:opacity-100 transition-opacity">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button class="text-[#f91880] text-[10px]">Delete</button>
                                                                </form>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
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