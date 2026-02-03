<?php

namespace App\Http\Controllers;

use App\Models\User;

class FriendshipController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $pendingRequests = $user->receivedFriendRequests()->get();
        $friends = $user->acceptedFriends();

        return view('friends.index', compact('pendingRequests'));
    }

    public function addPage()
    {
        $suggestions = User::where('id', '!=', auth()->id())
            ->inRandomOrder()
            ->limit(9)
            ->get();

        return view('friends.add', compact('suggestions'));
    }

    public function add($id)
    {
        $user = auth()->user();


        if ($user->id == $id) {
            return back()->with('error', "You can't add yourself.");
        }

        if ($user->friendship()->where('friend_id', $id)->exists()) {
            return back()->with('error', 'Already friends or request already sent.');
        }

        $user->friendships()->attach($id, [
            'status' => 'pending'
        ]);

        return back()->with('success', 'Friend request sent!');
    }

    public function accept($id)
    {
        $user = auth()->user();
        $user->receivedFriendRequests()->updateExistingPivot($id, ['status' => 'accepted']);
        return back()->with('success', 'Friend request accepted!');
    }

    public function reject($id)
    {
        $user = auth()->user();
        $user->receivedFriendRequests()->detach($id);
        return back()->with('success', 'Friend request declined.');
    }
}
