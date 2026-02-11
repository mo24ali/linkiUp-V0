<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FriendshipController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $pendingRequests = \App\Models\Invitation::where('receiver_id', $user->id)->with('sender')->get();
        // Also fetch accepted friends
        $friends = $user->friends()->wherePivot('status', 'accepted')->get()
            ->merge($user->friendsOf()->wherePivot('status', 'accepted')->get());

        return view('friends.index', compact('pendingRequests', 'friends'));
    }

    public function addPage(Request $request)
    {
        $pendingInvitations = \App\Models\Invitation::where('receiver_id', auth()->id())->with('sender')->get();

        $query = User::where('id', '!=', auth()->id());

        // Exclude already invited or friends
        $sentIds = \App\Models\Invitation::where('sender_id', auth()->id())->pluck('receiver_id')->toArray();
        $friendIds = auth()->user()->acceptedFriends()->pluck('id')->toArray();

        $excludeIds = array_merge($sentIds, $friendIds);

        $query->whereNotIn('id', $excludeIds);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('pseudo', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        } else {
            $query->inRandomOrder()->limit(9);
        }

        $suggestions = $query->get();

        return view('friends.add', compact('suggestions', 'pendingInvitations'));
    }

    public function add($id)
    {
        if (auth()->id() == $id)
            return back();

        // Check loops
        if (\App\Models\Invitation::where('sender_id', auth()->id())->where('receiver_id', $id)->exists()) {
            return back()->with('error', 'Already invited.');
        }

        \App\Models\Invitation::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $id,
            'body' => 'Friend request',
        ]);

        return back()->with('success', 'Invitation sent!');
    }

    public function accept($id)
    {
        // $id here is the Invitation ID according to logic, OR User ID.
        // Let's assume User ID to keep route consistent friends/accept/{id} where id is user.
        // Re-reading user request: "Added to invitation table... user can choose whether to accept or refuse".
        // I will implement finding the invitation by Sender ID ($id).

        $invitation = \App\Models\Invitation::where('sender_id', $id)->where('receiver_id', auth()->id())->first();

        if (!$invitation) {
            // Maybe $id IS the invitation ID?
            $invitation = \App\Models\Invitation::find($id);
        }

        if ($invitation && $invitation->receiver_id == auth()->id()) {
            // Create friendship
            $invitation->sender->friends()->attach($invitation->receiver_id, ['status' => 'accepted']);
            $invitation->delete();
            return back()->with('success', 'Friend request accepted!');
        }

        return back()->with('error', 'Invitation not found.');
    }

    public function reject($id)
    {
        $invitation = \App\Models\Invitation::where('sender_id', $id)->where('receiver_id', auth()->id())->first();
        if (!$invitation) {
            $invitation = \App\Models\Invitation::find($id);
        }

        if ($invitation && $invitation->receiver_id == auth()->id()) {
            $invitation->delete();
            return back()->with('success', 'Friend request rejected.');
        }
        return back()->with('error', 'Invitation not found.');
    }
}
