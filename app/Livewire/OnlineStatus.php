<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

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

    public function render()
    {
        return view('livewire.online-status');
    }
}