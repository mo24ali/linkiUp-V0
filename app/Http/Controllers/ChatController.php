<?php

namespace App\Http\Controllers;

use App\Events\MessageEvent;
use App\Events\MessageUpdated;
use App\Events\MessageDeleted;
use App\Models\Message;
use App\Models\User;
use App\Models\Conversation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function show()
    {
        $userId = Auth::id();

        // Get all users except current user
        $onlineUsers = User::where('id', '!=', $userId)->get();

        // Get conversations where the auth user is sender or receiver
        $conversations = Conversation::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->with([
                'sender',
                'receiver',
                'messages' => function ($query) {
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
                'content' => 'required|string|max:1000',
                'receiver_id' => 'required|exists:users,id'
            ]);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 422);
        }

        $senderId = Auth::id();
        $receiverId = $request->input('receiver_id');

        // Check for existing conversation (order agnostic)
        $conversation = Conversation::where(function ($q) use ($senderId, $receiverId) {
            $q->where('sender_id', $senderId)->where('receiver_id', $receiverId);})
                ->orWhere(function ($q) use ($senderId, $receiverId) {
            $q->where('sender_id', $receiverId)->where('receiver_id', $senderId);})
                ->first();

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

        broadcast(new MessageEvent($message))->toOthers();

        return response()->json([
            'status' => 'success',
            'message' => $message,
            'conversation_id' => $conversation->id
        ]);
    }

    public function fetchMessages(Conversation $conversation)
    {
        $userId = Auth::id();
        
        // Check authorization
        if ($userId !== $conversation->sender_id && $userId !== $conversation->receiver_id) {
            abort(403);
        }

        $messages = $conversation->messages()->with('sender')->get();

        return response()->json([
            'messages' => $messages
        ]);
    }

    public function update(Request $request, Message $message)
    {
            if ($message->sender_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $message->update([
            'content' => $request->content,
        ]);

        broadcast(new MessageUpdated($message))->toOthers();

        return response()->json([
            'status' => 'updated',
            'message' => $message
        ]);
    }

    public function destroy(Message $message)
    {
        if ($message->sender_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $messageId = $message->id;
        $conversationId = $message->conversation_id;

        $message->delete();

        broadcast(new MessageDeleted($messageId, $conversationId))->toOthers();

        return response()->json([
            'status' => 'deleted',
            'message_id' => $messageId
        ]);
    }
}