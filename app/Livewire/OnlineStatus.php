<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OnlineStatus extends Component
{
    public $friends;

    public function mount()
    {
        $this->loadFriends();
    }

    public function loadFriends()
    {
        $user = Auth::user();
        $this->friends = $user->acceptedFriends();
    }

    public function refreshStatus()
    {
        $this->loadFriends();
    }

    public function removeFriend($friendId)
    {
        $myId = auth()->id();
        DB::table('friendships')->where(function($q) use ($myId, $friendId){
            $q->where('friend_id', $friendId)->where('user_id', $myId);
        })
        ->orWhere(function($q) use ($myId, $friendId){
            $q->where('friend_id', $myId)->where('user_id', $friendId);
        })
        ->delete();
        $this->loadFriends();
        session()->flash('success', 'Ami supprimé !');
    }

    public function render()
    {
        return view('livewire.online-status');
    }
}