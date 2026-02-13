<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl tracking-tight text-[#e7e9ea]">
                {{ __('Messages') }}
            </h2>

            <div class="flex items-center space-x-2">
                <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                <span class="text-xs text-[#71767b] font-medium uppercase tracking-widest">Live Chat</span>
            </div>
        </div>
    </x-slot>

    <div class="grid grid-cols-12 gap-6 relative">
        <!-- LEFT SIDEBAR - Conversations & Online Users -->
        <aside id="chat-sidebar" class="col-span-12 md:col-span-4 lg:col-span-3 space-y-6">
            <!-- Conversations List -->
            <div class="glass-card p-4">
                <h3 class="font-bold text-[#e7e9ea] mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-[#1d9bf0]" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M19.25 3.018H4.75C3.233 3.018 2 4.252 2 5.77v12.495c0 1.518 1.233 2.753 2.75 2.753h14.5c1.517 0 2.75-1.235 2.75-2.753V5.77c0-1.518-1.233-2.752-2.75-2.752zm-14.5 1.5h14.5c.69 0 1.25.56 1.25 1.252v.918l-8.5 5.11-8.5-5.11v-.918c0-.692.56-1.252 1.25-1.252zm14.5 14.998H4.75c-.69 0-1.25-.56-1.25-1.252V8.516l8.5 5.11 8.5-5.11v9.748c0 .692-.56 1.252-1.25 1.252z" />
                    </svg>
                    Conversations
                </h3>

                <ul id="conversations-list" class="space-y-2">
                    @forelse ($conversations as $conversation)
                        @php
                            $otherUser =
                                $conversation->sender_id == auth()->id()
                                    ? $conversation->receiver
                                    : $conversation->sender;
                        @endphp
                        <li onclick="selectConversation({{ $conversation->id }}, {{ $otherUser->id }}, '{{ $otherUser->name }}')"
                            class="group p-3 rounded-xl hover:bg-[#202327] cursor-pointer transition-all"
                            id="conv-{{ $conversation->id }}">
                            <div class="flex items-center gap-3">
                                <div class="relative">
                                    @if ($otherUser->profile && $otherUser->profile->avatar)
                                        <img src="{{ Storage::url($otherUser->profile->avatar) }}"
                                            class="w-12 h-12 rounded-full object-cover border-2 border-[#2f3336] group-hover:border-[#1d9bf0] transition-colors">
                                    @else
                                        <div
                                            class="w-12 h-12 rounded-full bg-gradient-to-r from-[#1d9bf0] to-[#f91880] flex items-center justify-center text-white font-bold text-lg border-2 border-[#2f3336] group-hover:border-[#1d9bf0] transition-colors">
                                            {{ substr($otherUser->name, 0, 1) }}
                                        </div>
                                    @endif
                                    <span
                                        class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 rounded-full ring-2 ring-[#202327]"></span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex justify-between items-baseline">
                                        <p
                                            class="font-bold text-[#e7e9ea] truncate group-hover:text-[#1d9bf0] transition-colors">
                                            {{ $otherUser->name }}
                                        </p>
                                        @if ($conversation->messages->first())
                                            <span class="text-xs text-[#71767b]">
                                                {{ $conversation->messages->first()->created_at->diffForHumans(null, true, true) }}
                                            </span>
                                        @endif
                                    </div>
                                    <p class="text-sm text-[#71767b] truncate">
                                        {{ $conversation->messages->first()->content ?? 'No messages yet' }}
                                    </p>
                                </div>
                            </div>
                        </li>
                    @empty
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 text-[#71767b] mx-auto mb-3" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                            <p class="text-[#71767b] text-sm">No conversations yet</p>
                        </div>
                    @endforelse
                </ul>
            </div>

            <!-- Online Users / Start New Chat -->
            <div class="glass-card p-4">
                <h3 class="font-bold text-[#e7e9ea] mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-[#1d9bf0]" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M12 2C6.486 2 2 6.486 2 12s4.486 10 10 10 10-4.486 10-10S17.514 2 12 2zm0 18c-4.411 0-8-3.589-8-8s3.589-8 8-8 8 3.589 8 8-3.589 8-8 8zm-1-13h2v6h-2V7zm0 8h2v2h-2v-2z" />
                    </svg>
                    Start New Chat
                </h3>

                <ul class="space-y-2">
                    @foreach ($onlineUsers as $user)
                        <li onclick="startNewChat({{ $user->id }}, '{{ $user->name }}')"
                            class="group p-3 rounded-xl hover:bg-[#202327] cursor-pointer transition-all">
                            <div class="flex items-center gap-3">
                                <div class="relative">
                                    @if ($user->profile && $user->profile->avatar)
                                        <img src="{{ Storage::url($user->profile->avatar) }}"
                                            class="w-10 h-10 rounded-full object-cover border-2 border-[#2f3336] group-hover:border-[#1d9bf0] transition-colors">
                                    @else
                                        <div
                                            class="w-10 h-10 rounded-full bg-gradient-to-r from-[#1d9bf0] to-[#f91880] flex items-center justify-center text-white font-bold border-2 border-[#2f3336] group-hover:border-[#1d9bf0] transition-colors">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                    @endif
                                    <span
                                        class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-green-500 rounded-full ring-2 ring-[#202327]"></span>
                                </div>
                                <span class="font-medium text-[#e7e9ea] group-hover:text-[#1d9bf0] transition-colors">
                                    {{ $user->name }}
                                </span>
                            </div>
                        </li>
                    @endforeach
                </ul>

                @if ($onlineUsers->isEmpty())
                    <div class="text-center py-6">
                        <p class="text-[#71767b] text-sm">No users online at the moment</p>
                    </div>
                @endif
            </div>

            <div class="px-4 text-[13px] text-[#71767b] space-x-2">
                <a href="#" class="hover:underline">Terms of Service</a>
                <a href="#" class="hover:underline">Privacy Policy</a>
                <a href="#" class="hover:underline">Cookie Policy</a>
                <p class="mt-2">© 2026 LinkUp Corp.</p>
            </div>
        </aside>

        <!-- MAIN CHAT SECTION -->
        <main id="chat-main" class="col-span-12 md:col-span-8 lg:col-span-6 hidden md:block">
            <div class="glass-card p-0 flex flex-col h-[calc(100vh-180px)] relative">

                <!-- Chat Header -->
                <div id="chat-header"
                    class="p-5 border-b border-[#2f3336] sticky top-0 z-10 bg-black/80 backdrop-blur-md hidden">
                    <div class="flex items-center gap-3">
                        <button onclick="showSidebar()"
                            class="md:hidden mr-1 text-[#e7e9ea] hover:bg-[#202327] p-2 rounded-full transition-colors group">
                            <svg class="w-5 h-5 group-hover:text-[#1d9bf0]" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                        </button>
                        <div class="relative">
                            <div id="chat-avatar"
                                class="w-12 h-12 rounded-full bg-gradient-to-r from-[#1d9bf0] to-[#f91880] flex items-center justify-center text-white font-bold text-lg border-2 border-[#2f3336]">
                                <!-- Initial will be set via JS -->
                            </div>
                            <span
                                class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 rounded-full ring-2 ring-[#202327]"></span>
                        </div>
                        <div>
                            <h3 class="font-bold text-xl text-[#e7e9ea]" id="chat-user-name"></h3>
                            <p class="text-xs text-[#71767b]">Online</p>
                        </div>
                    </div>
                </div>

                <!-- Empty State -->
                <div id="empty-state" class="flex-1 flex flex-col items-center justify-center text-center p-8">
                    <svg class="w-20 h-20 text-[#71767b] mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <h3 class="text-xl font-bold text-[#e7e9ea] mb-2">Your Messages</h3>
                    <p class="text-[#71767b] max-w-xs">Select a conversation from the sidebar or start a new chat</p>
                </div>

                <!-- Messages Container -->
                <div id="messages" class="flex-1 overflow-y-auto p-6 space-y-4 bg-[#15181c] hidden">
                    <!-- Messages will be injected here -->
                </div>

                <!-- Input Area -->
                <form id="chat-form" class="p-5 border-t border-[#2f3336] hidden">
                    <div class="flex gap-3">
                        <input id="message-input" type="text"
                            class="flex-1 bg-[#202327] border-none rounded-xl px-5 py-3 text-[#e7e9ea] placeholder-[#71767b] focus:ring-1 focus:ring-[#1d9bf0] text-sm"
                            placeholder="Type a message...">
                        <button type="submit" class="btn-vibrant px-6">
                            Send
                        </button>
                    </div>
                </form>
            </div>
        </main>


    </div>

    @push('scripts')
        <script type="module">
            const authId = {{ auth()->id() }};
            let currentConversationId = null;
            let currentReceiverId = null;
            let echoChannel = null;

            const messagesDiv = document.getElementById('messages');
            const messageInput = document.getElementById('message-input');
            const chatHeader = document.getElementById('chat-header');
            const chatUserName = document.getElementById('chat-user-name');
            const chatAvatar = document.getElementById('chat-avatar');
            const emptyState = document.getElementById('empty-state');
            const chatForm = document.getElementById('chat-form');

            // Responsive Helpers
            window.showChat = function() {
                if (window.innerWidth < 768) {
                    document.getElementById('chat-sidebar').classList.add('hidden');
                    document.getElementById('chat-main').classList.remove('hidden');
                }
            }

            window.showSidebar = function() {
                if (window.innerWidth < 768) {
                    document.getElementById('chat-sidebar').classList.remove('hidden');
                    document.getElementById('chat-main').classList.add('hidden');
                }
            }

            // Make functions global
            window.selectConversation = async function(conversationId, receiverId, receiverName) {
                showChat();
                currentConversationId = conversationId;
                currentReceiverId = receiverId;

                setupChatUI(receiverName, receiverId);

                try {
                    const response = await fetch(`/chat/messages/${conversationId}`);
                    const data = await response.json();

                    messagesDiv.innerHTML = '';
                    data.messages.forEach(msg => addMessageToUI(msg));
                    scrollToBottom();

                    subscribeToConversation(conversationId);

                } catch (error) {
                    console.error('Error fetching messages:', error);
                }
            }

            window.startNewChat = function(receiverId, receiverName) {
                showChat();
                currentConversationId = null;
                currentReceiverId = receiverId;

                setupChatUI(receiverName, receiverId);
                messagesDiv.innerHTML = `
                <div class="flex flex-col items-center justify-center h-full text-center p-8">
                    <svg class="w-16 h-16 text-[#71767b] mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <p class="text-[#e7e9ea] font-medium">Start a conversation with ${receiverName}</p>
                    <p class="text-[#71767b] text-sm mt-2">Say hello! 👋</p>
                </div>
            `;

                if (echoChannel) {
                    window.Echo.leave(echoChannel);
                    echoChannel = null;
                }
            }

            function setupChatUI(name, userId) {
                // Set avatar with user's initial
                chatAvatar.innerHTML = name.charAt(0).toUpperCase();

                chatUserName.textContent = name;
                emptyState.classList.add('hidden');
                chatHeader.classList.remove('hidden');
                messagesDiv.classList.remove('hidden');
                chatForm.classList.remove('hidden');
                messageInput.focus();

                // Highlight selected conversation
                document.querySelectorAll('[id^="conv-"]').forEach(el => {
                    el.classList.remove('bg-[#202327]', 'border-l-4', 'border-[#1d9bf0]');
                });
                if (currentConversationId) {
                    const selectedConv = document.getElementById(`conv-${currentConversationId}`);
                    if (selectedConv) {
                        selectedConv.classList.add('bg-[#202327]', 'border-l-4', 'border-[#1d9bf0]');
                    }
                }
            }

            function subscribeToConversation(conversationId) {
                if (echoChannel) {
                    window.Echo.leave(echoChannel);
                }

                echoChannel = `chat.${conversationId}`;

                window.Echo.private(echoChannel)
                    .listen('.message.sent', (e) => {
                        addMessageToUI(e.message);
                        scrollToBottom();
                    });
            }

            function addMessageToUI(message) {
                const isOwn = message.sender_id === authId;
                const div = document.createElement('div');
                div.className = `flex ${isOwn ? 'justify-end' : 'justify-start'} animate-fadeIn`;

                const time = new Date(message.created_at).toLocaleTimeString([], {
                    hour: '2-digit',
                    minute: '2-digit'
                });

                div.innerHTML = `
                <div class="max-w-[70%] group relative">
                    <div class="rounded-2xl px-5 py-3 ${isOwn ? 'bg-[#1d9bf0] text-white' : 'bg-[#202327] text-[#e7e9ea]'}">
                        <p class="text-[15px] leading-relaxed">${escapeHtml(message.content)}</p>
                        <p class="text-[11px] opacity-70 mt-1 ${isOwn ? 'text-right' : 'text-left'}">
                            ${time}
                            ${isOwn ? '<span class="ml-1">✓✓</span>' : ''}
                        </p>
                    </div>
                </div>
            `;

                messagesDiv.appendChild(div);
            }

            // Helper to escape HTML
            function escapeHtml(unsafe) {
                return unsafe
                    .replace(/&/g, "&amp;")
                    .replace(/</g, "&lt;")
                    .replace(/>/g, "&gt;")
                    .replace(/"/g, "&quot;")
                    .replace(/'/g, "&#039;");
            }

            function scrollToBottom() {
                messagesDiv.scrollTop = messagesDiv.scrollHeight;
            }

            // Send Message
            chatForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                const content = messageInput.value.trim();
                if (!content || !currentReceiverId) return;

                try {
                    const response = await fetch('/chat/send', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            content: content,
                            receiver_id: currentReceiverId
                        })
                    });

                    const data = await response.json();

                    if (data.status === 'success') {
                        messageInput.value = '';
                        addMessageToUI(data.message);
                        scrollToBottom();

                        if (!currentConversationId && data.conversation_id) {
                            currentConversationId = data.conversation_id;
                            subscribeToConversation(currentConversationId);

                            // Reload conversations list or append new conversation
                            setTimeout(() => location.reload(), 1000);
                        }
                    }
                } catch (err) {
                    console.error('Send error:', err);
                }
            });

            // Add animation style
            const style = document.createElement('style');
            style.textContent = `
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(10px); }
                to { opacity: 1; transform: translateY(0); }
            }
            .animate-fadeIn {
                animation: fadeIn 0.3s ease-out;
            }
        `;
            document.head.appendChild(style);
        </script>
    @endpush
</x-app-layout>
