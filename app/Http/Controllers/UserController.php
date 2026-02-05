<?php

namespace App\Http\Controllers;

use Faker\Guesser\Name;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');
        $users = [];

        if ($query) {
            $users = User::where('name', 'LIKE', "%{$query}%")
                ->orWhere('email', 'LIKE', "%{$query}%")
                ->where('id', '!=', auth()->id())
                ->get();
        }

        return view('users.index', compact('users', 'query'));
    }

    public function show(User $user)
    {
        return redirect()->route('profile.show', $user->id);
    }

}
