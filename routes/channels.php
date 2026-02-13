<?php

use Illuminate\Support\Facades\Broadcast;

<<<<<<< HEAD
Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
=======
use App\Models\Conversation;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// Private channel for conversation
Broadcast::channel('chat.{conversation}', function ($user, Conversation $conversation) {
    return $user->id === $conversation->sender_id || $user->id === $conversation->receiver_id;
});
>>>>>>> 3eb72ef463e64be5c52cb1e34670dd12a44634f5
