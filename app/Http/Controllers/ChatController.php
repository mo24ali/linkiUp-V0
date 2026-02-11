<?php

namespace App\Http\Controllers;

use App\Events\MessageEvent;
use App\Models\Message;
use Illuminate\Http\Request;

class ChatController extends Controller
{


    // MUST IMPLEMENT THE SEE USERS AND RECEIVED MESSAGES LOGIC
    public function show(){
        
        return view('messagerie.index');
    }
    public function send(Request $request){
        $request->validate([
            'content' => 'required |string',
        ]);

        $message = Message::create([
            'sender_id' => auth()->id(),
            'content' => $request->input('content')
        ]);

        broadcast(new MessageEvent($message))->toOthers();

        return response()->json([
            'status' =>'success',
            'message' => $message
        ]);
    }
}
