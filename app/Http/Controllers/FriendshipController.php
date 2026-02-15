<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Invitation;
use Illuminate\Support\Facades\Auth;


class FriendshipController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $pendingRequests = Invitation::where('receiver_id', $user->id)->with('sender')->get();
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
        if (Invitation::where('sender_id', auth()->id())->where('receiver_id', $id)->exists()) {
            return back()->with('error', 'Already invited.');
        }

        Invitation::create([
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

        $currentUser = auth()->user();

        // Récupérer l'invitation
        $invitation = Invitation::where('sender_id', $id)
            ->where('receiver_id', $currentUser->id)
            ->first();

        if (!$invitation) {
            // Optionnel : essayer de trouver par invitation ID
            $invitation = Invitation::find($id);
        }

        if ($invitation && $invitation->receiver_id == $currentUser->id) {
            $sender = $invitation->sender;

            // Calculer min/max pour une seule ligne
            $user1Id = min($sender->id, $currentUser->id);
            $user2Id = max($sender->id, $currentUser->id);

            // Vérifier si l'amitié existe déjà
            $exists = User::find($user1Id)
                ->friends()
                ->where('friend_id', $user2Id)
                ->exists();

            if (!$exists) {
                // Créer l'amitié avec Eloquent
                User::find($user1Id)
                    ->friends()
                    ->attach($user2Id, [
                        'status' => 'accepted',
                        'created_at' => now(), 
                        'updated_at' => now()
                        ]);
            }

            // Supprimer l'invitation
            $invitation->delete();

            return back()->with('success', 'Friend request accepted!');
        }

        return back()->with('error', 'Invitation not found.');
    }

    public function reject($id)
    {
        $invitation = Invitation::where('sender_id', $id)->where('receiver_id', auth()->id())->first();
        if (!$invitation) {
            $invitation = Invitation::find($id);
        }

        if ($invitation && $invitation->receiver_id == auth()->id()) {
            $invitation->delete();
            return back()->with('success', 'Friend request rejected.');
        }
        return back()->with('error', 'Invitation not found.');
    }


    public function addFriendByQr($token){
        $currentUser = auth()->user(); //celui qui scanne
        $friend = User::where('qr_token', $token)->first();

        if (!$friend) {
            return "QR code invalide";
        }

        if ($currentUser->friends()->where('friend_id', $friend->id)) {
            return "Vous etes deja amis";
        }

        //Cree la relation d'amitie
        $currentUser->friends()->attach($friend->id);

        return "Amitie acceptee automatiquement";
    }

    public function addFriend($token)
    {
        $currentUser = auth()->user();

        // Trouver le user correspondant au token
        $friend = User::where('qr_token', $token)->first();

        if (!$friend) {
            return back()->with('error', 'QR code invalide.');
        }

        // Empêcher l'utilisateur de devenir ami avec lui-même
        if ($friend->id === $currentUser->id) {
            return back()->with('error', 'Vous ne pouvez pas devenir ami avec vous-même.');
        }

        // Calculer min/max pour la table pivot
        $user1Id = min($currentUser->id, $friend->id);
        $user2Id = max($currentUser->id, $friend->id);

        // Vérifier si l'amitié existe déjà
        $exists = \App\Models\User::find($user1Id)
            ->friends()
            ->where('friend_id', $user2Id)
            ->exists();

        if (!$exists) {
            \App\Models\User::find($user1Id)
                ->friends()
                ->attach($user2Id, [
                    'status' => 'accepted',   // <- obligatoire pour PostgreSQL
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
        }

        return back()->with('success', 'Amitié acceptée automatiquement !');
    }


    public function acceptFriend($slug)
    {
        $currentUser = auth()->user();

        // Trouver l'utilisateur via slug
        $friend = User::where('slug', $slug)->first();

        if (!$friend) {
            return back()->with('error', 'Lien invalide.');
        }

        // Empêcher auto-ajout connu
        if ($friend->id === $currentUser->id) {
            return back()->with('error', 'Vous ne pouvez pas devenir ami avec vous-même.');
        }

        // Sécuriser ordre pour pivot
        $user1Id = min($currentUser->id, $friend->id);
        $user2Id = max($currentUser->id, $friend->id);

        // Vérifier si amitié existe déjà
        $exists = User::find($user1Id)
            ->friends()
            ->where('friend_id', $user2Id)
            ->exists();

        if (!$exists) {
            User::find($user1Id)
                ->friends()
                ->attach($user2Id, [
                    'status' => 'accepted',
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
        }

        return back()->with('success', 'Amitié acceptée automatiquement !');
    }


   
}
