<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;

class FriendSearch extends Component
{
    public $search = '';

    public function addFriend($id)
    {
        $user = auth()->user();

        if ($user->id == $id) {
            return;
        }

        // Check if already friends or request sent (outgoing check as per controller)
        // Also good to check if we received one (then we should Accept, not Request)
        // For simplicity, matching Controller logic for now, but adding basic check.
        if ($user->friends()->where('friend_id', $id)->exists()) {
            session()->flash('success', 'Request already sent or unrelated.');
            return;
        }

        $user->friends()->attach($id, ['status' => 'pending']);
        session()->flash('success', 'Friend request sent to user #' . $id);
    }

    public function render()
    {
        $users = [];

        if (strlen($this->search) > 1) {
            $users = User::where('id', '!=', auth()->id())
                ->where(function ($query) {
                    $query->where('name', 'like', "%{$this->search}%")
                        ->orWhere('email', 'like', "%{$this->search}%");
                })
                ->limit(10)
                ->get();
        }

        return view('livewire.friend-search', compact('users'));
    }
}
