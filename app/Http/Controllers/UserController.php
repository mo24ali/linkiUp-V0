<?php

namespace App\Http\Controllers;

use Faker\Guesser\Name;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');
        $users = [];

        if ($query) {
            $users = \App\Models\User::where('name', 'LIKE', "%{$query}%")
                ->orWhere('email', 'LIKE', "%{$query}%")
                ->where('id', '!=', auth()->id())
                ->get();
        }

        return view('users.index', compact('users', 'query'));
    }

    public function show(\App\Models\User $user)
    {
        return redirect()->route('profile.show', $user->id);
    }

}
