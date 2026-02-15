<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Invitation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Test extends Component
{
    public string $q = '';

    public function searchUsers()
    {
        $q = trim($this->q);
        
        if($q == '') {
            return collect();
        }

        return User::query()
            ->where('id', '!=', Auth::id())
            ->where(function($query) use ($q) {
                $query->where('slug', 'ilike', "%{$q}%");
            })
            ->orderBy('slug')
            ->limit(10)
            ->get();
    }

    public function hasSentRequest($userId)
    {
        return Invitation::where('sender_id', auth()->id())->where('receiver_id', $userId)->exists();
    }

    public function isFriend(int $userId): bool
{
    return auth()->user()
        ->acceptedFriends()
        ->contains('id', $userId);
}

    public function addFriend($userId)
    {
        if($userId==auth()->id()) return;

        if(!$this->hasSentRequest($userId)) 
        {
            Invitation::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $userId,
            'body'=>'Friend request',
            ]);
        }
    }

    public function cancelRequest($userId)
    {
        Invitation::where('sender_id', auth()->id())
                    ->where('receiver_id', $userId)->delete();
    }

    public function render()
    {
        return view('livewire.test');
    }
}