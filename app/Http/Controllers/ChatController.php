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


use App\Models\MessageAttachment;
use App\Events\UnreadCountUpdated;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

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
            ->with([
                'sender',
                'receiver',
                'messages' => function ($query) {
                    $query->latest()->limit(1);
                }
            ])
            ->withCount([
                'messages as unread_count' => function ($query) use ($userId) {
                    $query->where('receiver_id', $userId)->whereNull('read_at');
                }
            ])
            ->get();

        return view('messagerie.index', compact('onlineUsers', 'conversations'));
    }

    private function broadcastUnreadCount($userId)
    {
        $unreadCount = Message::where('receiver_id', $userId)
            ->whereNull('read_at')
            ->count();

        $conversationCounts = Message::where('receiver_id', $userId)
            ->whereNull('read_at')
            ->select('conversation_id', DB::raw('count(*) as count'))
            ->groupBy('conversation_id')
            ->pluck('count', 'conversation_id');

        broadcast(new UnreadCountUpdated($userId, $unreadCount, $conversationCounts));
    }

    public function send(Request $request)
    {
        try {
            $request->validate([
                'content' => 'nullable|string|max:1000',
                'receiver_id' => 'required|exists:users,id',
                'attachment' => 'nullable|file|max:10240', // Max 10MB
            ]);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 422);
        }

        $senderId = Auth::id();
        $receiverId = $request->input('receiver_id');

        // Check if users are friends using the efficient cached method
        $friendIds = Auth::user()->getAcceptedFriendIds();
        if (!in_array($receiverId, $friendIds)) {
            return response()->json(['error' => 'You can only message confirmed friends.'], 403);
        }

        // Check for existing conversation (order agnostic)
        $conversation = Conversation::where(function ($q) use ($senderId, $receiverId) {
            $q->where('sender_id', $senderId)->where('receiver_id', $receiverId);
        })
            ->orWhere(function ($q) use ($senderId, $receiverId) {
                $q->where('sender_id', $receiverId)->where('receiver_id', $senderId);
            })
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
            'content' => $request->input('content') ?? '',
        ]);

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filename = $file->getClientOriginalName();
            $path = $file->store('attachments', 'public');

            MessageAttachment::create([
                'message_id' => $message->id,
                'filename' => $filename,
                'path' => $path,
                'mime_type' => $file->getMimeType(),
                'size' => $file->getSize(),
            ]);
        }

        $message->load('attachments');

        // Broadcast unread count to receiver
        $this->broadcastUnreadCount($receiverId);

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

        // Mark messages as read
        $updated = Message::where('conversation_id', $conversation->id)
            ->where('receiver_id', $userId)
            ->whereNull('read_at')
            ->update(['read_at' => now(), 'is_read' => true]);

        if ($updated > 0) {
            $this->broadcastUnreadCount($userId);
        }

        $messages = $conversation->messages()->with(['sender', 'attachments'])->get();

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