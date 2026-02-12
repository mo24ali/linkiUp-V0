<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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

    public function render()
    {
        return view('livewire.test');
    }
}