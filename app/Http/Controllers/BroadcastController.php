<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\NewMessage;

class BroadcastController extends Controller
{
    public function broadcastMessage()
    {
        event(new NewMessage('Hello, this is a new message!'));
        return 'Event has been broadcasted!';
    }

    public function sendMessage(Request $request)
    {
        $message = $request->input('message');
        event(new NewMessage($message));
        return response()->json(['message' => 'Message sent successfully']);
    }
}