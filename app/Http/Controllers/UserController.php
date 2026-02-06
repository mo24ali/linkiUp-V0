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

        $usersQuery = User::where('id', '!=', auth()->id())
            ->with('profile');

        if ($query) {
            $usersQuery->where(function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                    ->orWhere('email', 'LIKE', "%{$query}%");
            });
            $users = $usersQuery->get();
        } else {
            // Random discovery if no query
            $users = $usersQuery->inRandomOrder()->limit(12)->get();
        }

        return view('users.index', compact('users', 'query'));
    }

    public function show(User $user)
    {
        return redirect()->route('profile.show', $user->id);
    }

}
