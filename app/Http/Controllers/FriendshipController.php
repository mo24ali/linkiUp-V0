<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class FriendshipController extends Controller
{
    public function index()
    {
        $users = DB::table('users')->get();
        $profiles = DB::table('profiles')->get();

        return view('friends.index', compact('users', 'profiles'));
    }

    public function addPage()
    {
        $users = User::where('id', '!=', auth()->id())->get();
            return view('friends.add', compact('users'));
    }

    public function add($id)
    {
        $user = auth()->user();
        

        if ($user->id == $id) {
            return back()->with('error', "You can't add yourself.");
        }

        if ($user->friends()->where('friend_id', $id)->exists()) {
            return back()->with('error', 'Already friends or request already sent.');
        }

        $user->friends()->attach($id, [
            'status' => 'pending'
        ]);

        return back()->with('success', 'Friend request sent!');
    }
}
