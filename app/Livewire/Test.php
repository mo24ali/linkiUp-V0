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

    public function hasIncomingRequest(int $userId): bool
    {
        return Invitation::where('sender_id', $userId)
            ->where('receiver_id', auth()->id())
            ->exists();
    }

    public function addFriend($userId)
    {
        if($userId==auth()->id()) return;
        if($this->isFriend($userId)) return;
    
        if(!$this->hasSentRequest($userId)) 
        if(!$this->hasIncomingRequest($userId)) 

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
    
    public function rejectIncoming(int $userId)
    {
        Invitation::where('sender_id', $userId)
            ->where('receiver_id', auth()->id())
            ->delete();
    }

    public function acceptIncoming(int $userId)
    {
        $myId = auth()->id();

        $invitation = Invitation::where('sender_id', $userId)
            ->where('receiver_id', $myId)
            ->first();

        if (! $invitation) return;

        $exists = DB::table('friendships')
            ->where(function ($q) use ($myId, $userId) {
                $q->where('user_id', $myId)->where('friend_id', $userId);
            })
            ->orWhere(function ($q) use ($myId, $userId) {
                $q->where('user_id', $userId)->where('friend_id', $myId);
            })
            ->exists();

        if (! $exists) {
            DB::table('friendships')->insert([
                'user_id' => $myId,
                'friend_id' => $userId,
                'status' => 'accepted',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $invitation->delete();
    }


    public function render()
    {
        return view('livewire.test');
    }
}