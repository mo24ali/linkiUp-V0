<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Events\MessageRead;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function markAsRead(Request $request, $conversationId)
    {
        Message::where('conversation_id', $conversationId)
            ->where('user_id', '!=', Auth::id())
            ->whereNull('read_at')
            ->update(['read_at' => true]);

        // Optional: Broadcast event for real-time updates
        // broadcast(new MessageRead($conversationId, Auth::id()));

        return response()->json(['status' => 'success']);
    }
}
