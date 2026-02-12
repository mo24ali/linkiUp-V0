<?php

namespace App\Http\Controllers;

use App\Events\MessageEvent;
use App\Models\Message;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SebastianBergmann\Environment\Console;
use App\Models\User;
use App\Models\Conversation;

class ChatController extends Controller
{


    public function show()
    {
        $userId = Auth::id();

        //Get all users except current user
        $onlineUsers = User::where('id', '!=', $userId)->get(); // basic implementation for now

        // Get conversations where the auth user is sender or receiver
        $conversations = Conversation::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->with([
                'sender',
                'receiver',
                'messages' => function ($query) {
                    //eager load only the latest message
                    $query->latest()->limit(1);
                }
            ])
            ->get();

        return view('messagerie.index', compact('onlineUsers', 'conversations'));
    }

    public function send(Request $request)
    {
        try {
            $request->validate([
                'content' => 'required|string',
                'receiver_id' => 'required|exists:users,id'
            ]);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 422);
        }

        $senderId = Auth::id();
        $receiverId = $request->input('receiver_id');

        // Check for existing conversation (order agnostic)
        $conversation = Conversation::where(function ($q) use ($senderId, $receiverId) {
            $q->where('sender_id', $senderId)->where('receiver_id', $receiverId);
        })->orWhere(function ($q) use ($senderId, $receiverId) {
            $q->where('sender_id', $receiverId)->where('receiver_id', $senderId);
        })->first();

        // Create if not exists
        if (!$conversation) {
            $conversation = Conversation::create([
                'sender_id' => $senderId,
                'receiver_id' => $receiverId
            ]);
        }

        $message = Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $senderId,
            'receiver_id' => $receiverId,
            'content' => $request->input('content'),
        ]);

        event(new MessageEvent($message))->toOthers();

        return response()->json([
            'status' => 'success',
            'message' => $message,
            'conversation_id' => $conversation->id
        ]);
    }

    public function fetchMessages(Conversation $conversation)
    {
        // Check authorization
        $userId = Auth::id();
        if ($userId !== $conversation->sender_id && $userId !== $conversation->receiver_id) {
            abort(403);
        }

        $messages = $conversation->messages()->with('sender')->get();

        return response()->json([
            'messages' => $messages
        ]);
    }
}
