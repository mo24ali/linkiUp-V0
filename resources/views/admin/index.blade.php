<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Moderation') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white dark:bg-gray-800 p-6 shadow sm:rounded-lg">
                <h3 class="text-lg font-bold mb-4 dark:text-white">Pending Posts ({{ $pendingPosts->count() }})</h3>
                <div class="space-y-4">
                    @forelse($pendingPosts as $post)
                        <div class="border dark:border-gray-700 p-4 rounded-lg flex justify-between items-center">
                            <div>
                                <p class="font-bold dark:text-white">{{ $post->user->name }}</p>
                                <p class="text-gray-600 dark:text-gray-400">{{ $post->content }}</p>
                            </div>
                            <div class="flex gap-2">
                                <form action="{{ route('admin.approve', $post) }}" method="POST">
                                    @csrf
                                    <x-primary-button class="bg-green-600 hover:bg-green-700">Approve</x-primary-button>
                                </form>
                                <form action="{{ route('admin.reject', $post) }}" method="POST">
                                    @csrf
                                    <x-danger-button>Reject</x-danger-button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500">No pending posts.</p>
                    @endforelse
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 p-6 shadow sm:rounded-lg">
                <h3 class="text-lg font-bold mb-4 dark:text-white">Flagged Posts ({{ $flaggedPosts->count() }})</h3>
                <div class="space-y-4">
                    @forelse($flaggedPosts as $post)
                        <div class="border dark:border-gray-700 p-4 rounded-lg flex justify-between items-center">
                            <div>
                                <p class="font-bold dark:text-white">{{ $post->user->name }}</p>
                                <p class="text-gray-600 dark:text-gray-400">{{ $post->content }}</p>
                            </div>
                            <div class="flex gap-2">
                                <form action="{{ route('admin.reject', $post) }}" method="POST">
                                    @csrf
                                    <x-danger-button>Delete</x-danger-button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500">No flagged posts.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>