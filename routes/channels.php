<?php

use Illuminate\Support\Facades\Broadcast;

use App\Models\Conversation;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// Private channel for conversation
Broadcast::channel('chat.{conversation}', function ($user, Conversation $conversation) {
    return $user->id === $conversation->sender_id || $user->id === $conversation->receiver_id;
});
