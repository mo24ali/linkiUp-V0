<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;

class FriendSearch extends Component
{
    public $search = '';

    public function render()
    {
        $users = [];

        if(strlen($this->search) > 2){
            $users = User::where('id', '!=', auth()->id())
                ->where('name', 'like', "%{$this->search}%")
                ->limit(10)
                ->get();
        }

        return view('livewire.friend-search', compact('users'));
    }
}
