<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class ChatMessageController extends Controller
{

    public function sendMessage(Request $request)
    {
        $chat = Chat::find($request->chat_id);

        if (!$chat) {
            return response()->json(['error' => 'Chat not found'], 404);
        }

        $user = Auth::guard('admin')->user();
        if (Gate::forUser($user)->denies('sendMessages', $chat)) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $message = ChatMessage::create([
            'chat_id' => $request->chat_id,
            'by_customer' => $request->by_customer,
            'message_content' => $request->message_content,
            'message_type' => $request->message_type
        ]);

        if ($message->exists) {
            return response()->json(['success' => 'Message saved successfully!', 'data' => $message]);
        }

        return response()->json(['error' => 'Failed to save message'], 500);
    }

    public function getMessages(Request $request)
    {
        $chat = Chat::find($request->chat_id);

        if (!$chat) {
            return response()->json(['error' => 'Chat not found'], 404);
        }

        if (Gate::denies('getMessages', $chat)) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $messages = ChatMessage::where(function ($query) use ($request) {
            $query->where('chat_id', $request->chat_id);
        })->get();

        return response()->json([
            'messages' => $messages,
        ]);
    }
}
