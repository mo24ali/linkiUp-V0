<div class="w-full max-w-lg mx-auto">

    {{-- Search Input --}}
    <input 
        type="text" 
        wire:model.live="search"
        placeholder="Search friends..."
        class="w-full p-2 border rounded-lg focus:ring focus:ring-blue-300"
    >

    {{-- Results --}}
    @if(strlen($search) > 2)
        <div class="bg-white shadow rounded-lg mt-2 max-h-60 overflow-y-auto">

            @forelse($users as $user)
                <div class="flex items-center justify-between p-2 border-b hover:bg-gray-100">

                    <div class="flex items-center gap-3">
                        <img 
                            src="{{ $user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name) }}" 
                            class="w-8 h-8 rounded-full"
                        >
                        <span>{{ $user->name }}</span>
                    </div>

                    {{-- Add Friend --}}
                    <form action="{{ route('friends.add', $user->id) }}" method="POST">
                        @csrf
                        <button class="text-sm bg-blue-500 text-white px-2 py-1 rounded">
                            Add
                        </button>
                    </form>

                </div>
            @empty
                <p class="p-2 text-gray-500">No users found...</p>
            @endforelse

        </div>
    @endif

</div>
