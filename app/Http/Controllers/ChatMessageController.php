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
    public function initCustomerChat(Request $request)
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

            return response()->json(['success' => true, 'info' => 'No active chat'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'info' => $e->getMessage()], 500);
        }
    }

    public function initAdminChatList()
    {
        try {
            // Check if got logged in
            if (!Auth::guard('admin')->check()) {
                return response()->json(['success' => false, 'info' => 'Unauthorized'], 403);
            }

            $user = Auth::guard('admin')->user();

            // Check if the user have an active chat
            $chat_list = Chat::where('admin_id', $user->admin_id)->whereIn('status', ['active','pending'])->get()
            ->map(function($chat){

                $customer = Customer::find($chat->customer_id);

                if(!$customer) return null;

                return [
                    'chat_id' => $chat->chat_id,
                    'customer_id' => $chat->customer_id,
                    'customer_name' => $customer->username,
                    'status' => $chat->status,
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

    private function getAllMessage($chat_id)
    {
        try {
            $messages = ChatMessage::where('chat_id', $chat_id)->get();
            $message_contents = [];

            foreach ($messages as $message) {
                $message_obj = MessageFactory::create($message);
                $message_content = $message_obj->getContent();
                if($message_content){
                    $message_contents[] = $message_content;
                }else{
                    $message_contents[] = $this->generateFailedMessage();
                }
            }
            return response()->json([
                'success' => true,
                'messages' => $message_contents
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'info' => $e->getMessage()], 500);
        }
    }

    private function generateFailedMessage(){
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

            // Check if the user have an active chat
            $active_chat = Chat::where('customer_id', $user_id)->where('status', 'active')->first();
            $chat_id = null;

            if (!$active_chat) {
                $chat_id = $this->createChat($user_id);
            }else{
                $chat_id = $active_chat->chat_id;
            }

            // Validate the request data
            $request->validate([
                'message_type' => 'required|string|in:text,image,product',
            ]);

            $message_type = $request->input('message_type');

            if($message_type == 'text'){
                $request->validate([
                    'message_content' => 'required|string',
                ]);
                $message_content = $request->input('message_content');
            }else if($message_type == 'image'){
                $request->validate([
                    'message_content' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ]);

                $image = $request->file('message_content');
                $image_name = time().'.'.$image->extension();
                $image->storeAs('public/images/chats/'.$chat_id, $image_name);
                $message_content = $image_name;
            }else if($message_type == 'product'){
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
            $message->by_customer = 1;
            $message->save();

            return response()->json([
                'success' => true,
                'message' => $message,
            ], 201); 
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'info' => 'Invalid data',
                'message' => $message_type,
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

            if($new_chat) {
                return $new_chat->chat_id;
            }
            return null;

        } catch (\Exception $e) {
            return null;
        }
    }

}
