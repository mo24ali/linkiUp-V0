<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Feed') }}
        </h2>
    </x-slot>

    <div class="py-6 bg-gray-100 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 grid grid-cols-12 gap-4">

            <!-- LEFT SIDEBAR -->
            <aside class="col-span-3 hidden lg:block">
                <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow">
                    <h3 class="font-bold mb-3">Menu</h3>
                    <ul class="space-y-2 text-sm">
                        <li class="hover:text-blue-500 cursor-pointer">🏠 Home</li>
                        <li class="hover:text-blue-500 cursor-pointer">👥 Friends</li>
                        <li class="hover:text-blue-500 cursor-pointer">💬 Messages</li>
                        <li class="hover:text-blue-500 cursor-pointer">⚙️ Settings</li>
                    </ul>
                </div>
            </aside>

            <!-- FEED CENTER -->
            <main class="col-span-12 lg:col-span-6 space-y-4">

                <!-- Create Post Box -->
                <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow">
                    <div class="flex items-center gap-3">
                        <img src="https://i.pravatar.cc/40" class="w-10 h-10 rounded-full">
                        <input type="text" placeholder="What's on your mind?"
                            class="w-full bg-gray-100 dark:bg-gray-700 px-4 py-2 rounded-full focus:outline-none">
                    </div>
                </div>

                <!-- Example Post -->
                <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow">
                    @foreach ($posts as $post)
                        <div class="bg-white p-4 rounded-xl shadow">
                            <p>{{ $post->content }}</p>
                        </div>
                    @endforeach


                    <p class="text-sm mb-3">
                        This is my first post on LinkiUp 🚀
                    </p>

                    <div class="flex justify-between text-sm text-gray-500 border-t pt-2">
                        <button class="hover:text-blue-500">👍 Like</button>
                        <button class="hover:text-blue-500">💬 Comment</button>
                        <button class="hover:text-blue-500">↗ Share</button>
                    </div>
                </div>

            </main>

            <!-- RIGHT SIDEBAR -->
            <aside class="col-span-3 hidden lg:block">
                <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow">
                    <h3 class="font-bold mb-3">Suggestions</h3>
                    <ul class="space-y-2 text-sm">
                        <li class="flex items-center gap-2">
                            <img src="https://i.pravatar.cc/30?img=5" class="w-8 h-8 rounded-full">
                            <span>Alex</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <img src="https://i.pravatar.cc/30?img=6" class="w-8 h-8 rounded-full">
                            <span>Sarah</span>
                        </li>
                    </ul>
                </div>
            </aside>

        </div>
    </div>
</x-app-layout>
