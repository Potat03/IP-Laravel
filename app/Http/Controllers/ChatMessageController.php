<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use App\Factories\MessageFactory;
use App\Models\Customer;

class ChatMessageController extends Controller
{
    public function initCustomerChat()
    {
        try {
            // Check if got logged in
            if (!Auth::guard('customer')->check()) {
                return response()->json(['success' => false, 'info' => 'Unauthorized'], 403);
            }

            $user = Auth::guard('customer')->user();

            // Check if the user have an active chat
            $active_chat = Chat::where('customer_id', $user->customer_id)->where('status', 'active')->first();

            if ($active_chat) {
                return $this->getAllMessage($active_chat->chat_id);
            }

            return response()->json(['isActive' => false, 'info' => 'No active chat'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'info' => $e->getMessage()], 500);
        }
    }

    public function initAdminChatList()
    {
        try {
            $user = Auth::guard('admin')->user();

            // Check if the user have an active chat
            $chat_list = Chat::where('admin_id', $user->admin_id)->whereIn('status', ['active', 'pending'])->get()
                ->map(function ($chat) {

                    $customer = Customer::find($chat->customer_id);

                    if (!$customer) return null;

                    $latest_message = ChatMessage::where('chat_id', $chat->chat_id)->latest('created_at')->first();

                    return [
                        'chat_id' => $chat->chat_id,
                        'customer_id' => $chat->customer_id,
                        'customer_name' => $customer->username,
                        'status' => $chat->status,
                        'latest_message' => $latest_message ? $latest_message->message_content : "No message yet",
                    ];
                })->filter(); // to remove null rows

            return response()->json([
                'success' => true,
                'chat_list' => $chat_list
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'info' => $e->getMessage()], 500);
        }
    }

    public function adminGetMessage(Request $request)
    {
        try {
            $user = Auth::guard('admin')->user();

            $chat_id = $request->chat_id;

            if (!$chat_id) {
                return response()->json(['success' => false, 'info' => 'Chat ID is required'], 400);
            }

            $chat = Chat::find($chat_id);

            if (!$chat) {
                return response()->json(['success' => false, 'info' => 'Chat not found'], 404);
            }

            if (Gate::forUser($user)->denies('viewChat', $chat)) {
                return response()->json(['success' => false, 'info' => 'Unauthorized'], 403);
            }

            return $this->getAllMessage($chat_id);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'info' => $e->getMessage()], 500);
        }
    }

    private function getAllMessage($chat_id)
    {
        try {
            $messages = ChatMessage::where('chat_id', $chat_id)->get();
            $message_contents = [];
            $last_msg_id = 0;
            foreach ($messages as $message) {
                $message_obj = MessageFactory::create($message);
                $message_content = $message_obj->getContent();
                if ($message_content) {
                    $message_contents[] = $message_content;
                } else {
                    $message_contents[] = $this->generateFailedMessage();
                }
            }

            if ($message_contents != []) {
                $last_msg_id = $messages->last()->message_id;
            }

            return response()->json([
                'success' => true,
                'messages' => $message_contents,
                'chat_id' => $chat_id,
                'last_msg_id' => $last_msg_id
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'info' => $e->getMessage()], 500);
        }
    }

    private function generateFailedMessage()
    {
        return [
            'type' => 'TEXT',
            'content' => 'Sorry, failed to load this message'
        ];
    }

    public function sendMessage(Request $request)
    {
        try {
            // Check if got logged in
            if (!Auth::guard('customer')->check() && !Auth::guard('admin')->check()) {
                return response()->json(['success' => false, 'info' => 'Unauthorized'], 403);
            }

            $user = Auth::guard('customer')->user() ?? Auth::guard('admin')->user();
            $user_id = $user->customer_id ?? $user->admin_id;

            // Validate the request data for chat_id
            $request->validate([
                'chat_id' => 'required|integer',
                'by_customer' => 'required|integer|in:0,1',
            ]);

            $chat_id = $request->input('chat_id');

            // Check if the chat is active
            $active_chat = Chat::find($chat_id);

            if (!$active_chat) {
                return response()->json(['success' => false, 'info' => 'Chat not found'], 404);
            }

            if ($active_chat->status != 'active') {
                return response()->json(['success' => false, 'info' => 'Chat is not active'], 400);
            }

            // Validate the request data
            $request->validate([
                'message_type' => 'required|string|in:text,image,product',
            ]);

            $message_type = $request->input('message_type');

            if ($message_type == 'text') {
                $request->validate([
                    'message_content' => 'required|string',
                ]);
                $message_content = $request->input('message_content');
            } else if ($message_type == 'image') {
                $request->validate([
                    'message_content' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ]);

                $image = $request->file('message_content');
                $image_name = time() . '.' . $image->extension();
                $image->storeAs('public/images/chats/' . $chat_id, $image_name);
                $message_content = $image_name;
            } else if ($message_type == 'product') {
                $request->validate([
                    'message_content' => 'required|integer',
                ]);
                $message_content = $request->input('message_content');
            }

            // Create a new chat message
            $message = new ChatMessage();
            $message->message_type = $message_type;
            $message->message_content = $message_content;
            $message->chat_id = $active_chat->chat_id;
            $message->by_customer = $request->input('by_customer');
            $message->save();

            $message_id = $message->message_id;

            return response()->json([
                'success' => true,
                'info' => $message,
                'message_id' => $message_id
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'info' => 'Invalid data',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'info' => $e->getMessage()
            ], 500);
        }
    }

    public function fetchLatestMessages(Request $request)
    {
        try {
            // Check if got logged in
            if (!Auth::guard('customer')->check() && !Auth::guard('admin')->check()) {
                return response()->json(['success' => false, 'info' => 'Unauthorized'], 403);
            }

            $user = Auth::guard('customer')->user() ?? Auth::guard('admin')->user();
            $user_id = $user->customer_id ?? $user->admin_id;

            // Validate the request data for chat_id
            $request->validate([
                'chat_id' => 'required|integer',
                'last_msg_id' => 'required|integer',
            ]);

            $chat_id = $request->input('chat_id');
            $last_msg_id = $request->last_msg_id;
            // Check if the chat is active
            $active_chat = Chat::find($chat_id);

            if (!$active_chat) {
                return response()->json(['success' => false, 'info' => 'Chat not found'], 404);
            }

            if ($active_chat->status != 'active') {
                return response()->json(['success' => false, 'info' => 'Chat is not active'], 400);
            }

            // where msg id > last_msg_id
            $latest_messages = ChatMessage::where('chat_id', $chat_id)->where('message_id', '>', $last_msg_id)->get();

            if (!$latest_messages) {
                return response()->json(['success' => false, 'info' => 'No message found'], 404);
            }

            $message_contents = [];

            foreach ($latest_messages as $message) {
                $message_obj = MessageFactory::create($message);
                $message_content = $message_obj->getContent();
                if ($message_content) {
                    $message_contents[] = $message_content;
                } else {
                    $message_contents[] = $this->generateFailedMessage();
                }
            }

            

            if ($message_contents != []) {
                $last_msg_id = $latest_messages->last()->message_id;
            }

            return response()->json([
                'success' => true,
                'messages' => $message_contents,
                'last_msg_id' => $last_msg_id
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'info' => 'Invalid data',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'info' => $e->getMessage()
            ], 500);
        }
    }

    private function createChat($customer_id)
    {
        try {
            $chat = new Chat();
            $chat->customer_id = $customer_id;
            $chat->status = 'pending';
            $chat->save();

            $new_chat = Chat::where('customer_id', $customer_id)->where('status', 'pending')->first();

            if ($new_chat) {
                return $new_chat->chat_id;
            }
            return null;
        } catch (\Exception $e) {
            return null;
        }
    }
}
