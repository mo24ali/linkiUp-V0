<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Messages
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-4">

                <div class="grid grid-cols-4 gap-4 h-[600px]">

                    <!-- USERS LIST -->
                    <div class="col-span-1 border-r border-gray-300 dark:border-gray-700 p-2 overflow-y-auto">

                        <h3 class="text-lg font-bold mb-2 text-gray-700 dark:text-gray-200">
                            Users
                        </h3>

                        <!-- Connected users -->
                        <div class="mb-4">
                            <h4 class="text-sm font-semibold text-green-500">🟢 Connected</h4>
                            <ul id="online-users" class="space-y-2 mt-2">
                                <!-- Filled dynamically -->
                            </ul>
                        </div>

                        <!-- Users who sent messages -->
                        <div>
                            <h4 class="text-sm font-semibold text-blue-500">💬 Conversations</h4>
                            <ul id="chat-users" class="space-y-2 mt-2">
                                <!-- Filled dynamically -->
                            </ul>
                        </div>
                    </div>

                    <!-- CHAT AREA -->
                    <div class="col-span-3 flex flex-col h-full">

                        <!-- Messages -->
                        <div id="messages"
                            class="flex-1 border border-gray-300 dark:border-gray-700 rounded p-3 overflow-y-auto bg-gray-50 dark:bg-gray-900">
                        </div>

                        <!-- Input -->
                        <form id="chat-form" class="mt-3 flex gap-2">
                            <input type="text" id="message-input"
                                class="flex-1 border rounded px-3 py-2 dark:bg-gray-700 dark:text-white"
                                placeholder="Type a message...">

                            <button class="bg-blue-500 text-white px-4 py-2 rounded">
                                Send
                            </button>
                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    let messagesDiv = document.getElementById('messages');
    let onlineUsers = document.getElementById('online-users');
    let chatUsers = document.getElementById('chat-users');

    // // Example dummy users
    // let users = [{
    //         id: 1,
    //         name: "Ali",
    //         online: true
    //     },
    //     {
    //         id: 2,
    //         name: "Sara",
    //         online: false
    //     },
    // ];

    // Render users
    users.forEach(u => {
        let li = document.createElement("li");
        li.className = "p-2 rounded cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-700";
        li.innerText = u.name;

        if (u.online) {
            onlineUsers.appendChild(li);
        } else {
            chatUsers.appendChild(li);
        }
    });

    // Fake message render
    function addMessage(user, text) {
        let msg = document.createElement("div");
        msg.className = "mb-2";
        msg.innerHTML = `<b>${user}:</b> ${text}`;
        messagesDiv.appendChild(msg);
    }
</script>
