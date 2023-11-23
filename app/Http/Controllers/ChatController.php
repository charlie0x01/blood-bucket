<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function getMessages(Request $request, User $recipient)
    {
        // Retrieve messages between the authenticated user and the recipient
        $messages = Message::where(function ($query) use ($recipient, $request) {
            $query->where('sender_id', auth()->user()->id)
                ->where('recipient_id', $recipient->id);
        })->orWhere(function ($query) use ($recipient, $request) {
            $query->where('recipient_id', auth()->user()->id)
                ->where('sender_id', $recipient->id);
        })->get();

        return response()->json($messages);
    }

    public function sendMessage(Request $request, User $recipient)
    {
        // Validate request
        $request->validate([
            'content' => 'required',
        ]);

        // Create a new message
        $message = new Message();
        $message->sender_id = auth()->user()->id;
        $message->recipient_id = $recipient->id;
        $message->content = $request->input('content');
        $message->save();

        return response()->json($message);
    }
}
