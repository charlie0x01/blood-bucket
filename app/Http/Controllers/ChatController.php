<?php

namespace App\Http\Controllers;

use App\Models\BloodRequest;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

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

    public function sendMessage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'content' => 'required',
        ]);

        if ($validator->fails()) {
            Session::flash('error', 'message is empty');
            return redirect()->route('chat.with.donor', ['bid' => $request->bid]);
        }

        // Create a new message
        $message = new Message();
        $message->blood_request_id = $request->bid;
        $message->sender_id = auth()->user()->id;
        $message->receiver_id = $request->rid;
        $message->content = $request->input('content');
        $message->save();

        return redirect()->route('chat.with.donor', ['bid' => $request->bid]);
    }

    public function chatWithDonor($bid)
    {

        $bloodRequest = BloodRequest::join('blood_groups as bg', 'bg.id', '=', 'blood_requests.blood_group_id')
            ->join('cities', 'cities.id', '=', 'blood_requests.city_id')
            ->join('users as donor', 'donor.id', '=', 'blood_requests.donor_id')
            ->join('users as recipient', 'recipient.id', '=', 'blood_requests.sender_id')
            ->where('blood_requests.id', '=', $bid)
            ->where('blood_requests.request_state', '!=', BloodRequest::REQ_FULFILLED)
            ->orderBy('blood_requests.need_on', 'desc')
            ->orderBy('blood_requests.emergency_flag', 'desc')
            ->get([
                'blood_requests.id',
                'blood_requests.sender_id as recipient_id',
                'blood_requests.recipient_name',
                'blood_requests.donor_id',
                'donor.name as donor_name',
            ]);
        $sender_id = 0;
        $receiver_id = 0;
        $receiver_name = '';
        $sender_name = '';
        foreach ($bloodRequest as $b) {

            if($b->donor_id == Auth::id())
            {
                $sender_id = $b->donor_id;
                $sender_name = $b->donor_name;

                $receiver_id = $b->recipient_id;
                $receiver_name = $b->recipient_name;
            } else {
                $sender_id = $b->recipient_id;
                $sender_name = $b->recipient_name;

                $receiver_id = $b->donor_id;
                $receiver_name = $b->donor_name;
            }
        }

        $messages = Message::where('blood_request_id', '=', $bid)->get();

        return view('chat', [
            'bid' => $bid,
            'sender_id' => $sender_id, 
            'sender_name' => $sender_name, 
            'receiver_id' => $receiver_id, 
            'receiver_name' => $receiver_name,
            'messages' => $messages
        ]);
    }
}
