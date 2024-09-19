<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use App\Factories\MessageFactory;
use App\Models\Customer;
use App\Services\WebPurifyService;
use App\Models\Admin;
use DOMDocument;
use Illuminate\Support\Facades\Log;

class ChatMessageController extends Controller
{
    // TO check bad word de API
    protected $webPurify;

    public function __construct(WebPurifyService $webPurify)
    {
        $this->webPurify = $webPurify;
    }

    // If false = got bad word using WebPurify API
    public function checkMessage($message)
    {
        $profanity_found = $this->webPurify->checkProfanity($message);
        if ($profanity_found) {
            return false;
        }
        return true;
    }


    public function initCustomerChat()
    {
        try {
            // Check if got logged in
            if (!Auth::guard('customer')->check()) {
                return response()->json(['success' => false, 'info' => 'Please login to continue'], 403);
            }

            $user = Auth::guard('customer')->user();

            //use guard to check if allowed
            if (Gate::forUser($user)->denies('getChatList')) {
                return response()->json(['success' => false, 'info' => 'You account is inactive.'], 403);
            }

            // Check if the user have an active chat
            $active_chat = Chat::where('customer_id', $user->customer_id)->whereIn('status', ['active', 'pending'])->first();

            if ($active_chat) {

                //use guard to check if allowed
                if (Gate::forUser($user)->denies('viewChat', $active_chat)) {
                    return response()->json(['success' => false, 'info' => 'You are not allowed to view this chat.'], 403);
                }

                return $this->getAllMessage($active_chat->chat_id);
            }

            return response()->json(['isActive' => false, 'info' => 'No active/pending chat'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'info' => $e->getMessage()], 500);
        }
    }

    public function initAdminChatList()
    {
        try {
            // Check if got logged in
            if (!Auth::guard('admin')->check()) {
                return response()->json(['success' => false, 'info' => 'Please login to continue'], 403);
            }

            $user = Auth::guard('admin')->user();

            //use guard to check if allowed
            if (Gate::forUser($user)->denies('getChatList')) {
                return response()->json(['success' => false, 'info' => 'You account is inactive.'], 403);
            }

            // Check if the user have an active chat
            $chat_list = Chat::where('status', 'active')
                ->where('admin_id', $user->admin_id)
                ->orWhere('status', 'pending')
                ->whereNull('admin_id')
                ->get()
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


    // If failed to load message (e.g. image not found and product )
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


            // Validate the request data for chat_id
            $request->validate([
                'chat_id' => 'required|integer',
                'by_customer' => 'required|integer|in:0,1',
            ]);

            $user = null;

            if ($request->by_customer == 1) {
                $user = Auth::guard('customer')->user();
            } else {
                $user = Auth::guard('admin')->user();
            }

            if (!$user) {
                return response()->json(['success' => false, 'info' => 'Unauthorized'], 403);
            }

            $chat_id = $request->chat_id;

            // Check if the chat is active
            $active_chat = Chat::find($chat_id);

            //use guard to check if allowed
            if (Gate::forUser($user)->denies('sendMessages', $active_chat)) {
                return response()->json(['success' => false, 'info' => 'You are not allowed to send this chat.'], 403);
            }

            if (!$active_chat) {
                return response()->json(['success' => false, 'info' => 'Chat not found'], 404);
            }

            if ($active_chat->status == 'ended') {
                return response()->json(['success' => false, 'info' => 'Chat is ended'], 400);
            }

            // Validate the request data
            $request->validate([
                'message_type' => 'required|string|in:text,image,product',
            ]);

            $message_type = $request->message_type;

            if ($message_type == 'text') {
                $request->validate([
                    'message_content' => 'required|string',
                ]);

                $message_content = $request->message_content;

                // Check for bad words
                if (!$this->checkMessage($message_content)) {
                    return response()->json([
                        'success' => false,
                        'info' => 'Please avoid using inappropriate language.'
                    ], 400);
                }
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
                $message_content = $request->message_content;
            }

            // Create a new chat message
            $message = new ChatMessage();
            $message->message_type = $message_type;
            $message->message_content = $message_content;
            $message->chat_id = $active_chat->chat_id;
            $message->by_customer = $request->by_customer;
            $message->save();

            $message_id = $message->message_id;

            return response()->json([
                'success' => true,
                'info' => $message,
                'message_id' => $message_id
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) { // Validation got problem return this
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


    public function adminGetMessage(Request $request)
    {
        try {
            // Check if got logged in
            if (!Auth::guard('admin')->check()) {
                return response()->json(['success' => false, 'info' => 'Unauthorized'], 403);
            }

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
                return response()->json(['success' => false, 'info' => 'You are not allowed in this chat.'], 403);
            }

            return $this->getAllMessage($chat_id);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'info' => $e->getMessage()], 500);
        }
    }

    // For live-update
    public function fetchLatestMessages(Request $request)
    {
        try {
            // Validate the request data for chat_id
            $request->validate([
                'chat_id' => 'required|integer',
                'last_msg_id' => 'required|integer',
                'by_customer' => 'required|integer|in:0,1',
            ]);

            $user = null;

            if ($request->by_customer == 1) {
                $user = Auth::guard('customer')->user();
            } else {
                $user = Auth::guard('admin')->user();
            }

            if (!$user) {
                return response()->json(['success' => false, 'info' => 'Unauthorized'], 403);
            }

            $chat_id = $request->chat_id;
            $last_msg_id = $request->last_msg_id;
            // Check if the chat is active
            $active_chat = Chat::find($chat_id);

            if (Gate::forUser($user)->denies('viewChat', $active_chat)) {
                return response()->json(['success' => false, 'info' => 'You are not allowed in this chat.'], 403);
            }

            if (!$active_chat) {
                return response()->json(['success' => false, 'info' => 'Chat not found'], 404);
            }

            if ($active_chat->status === 'ended') {
                return response()->json(['success' => false, 'info' => 'Chat is ended'], 200);
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

    public function acceptChat(Request $request)
    {
        try {
            // Check if got logged in
            if (!Auth::guard('admin')->check()) {
                return response()->json(['success' => false, 'info' => 'Unauthorized'], 403);
            }

            $user = Auth::guard('admin')->user();

            // Validate the request data for chat_id
            $request->validate([
                'chat_id' => 'required|integer',
            ]);

            $chat_id = $request->chat_id;

            // Get the chat
            $chat = Chat::find($chat_id);

            if (!$chat) {
                return response()->json(['success' => false, 'info' => 'Chat not found'], 404);
            }

            if ($chat->status != 'pending') {
                return response()->json(['success' => false, 'info' => 'Chat cannot be accept'], 400);
            }

            if (Gate::forUser($user)->denies('acceptChat', $chat)) {
                return response()->json(['success' => false, 'info' => 'You are not allowed to accept this chat.'], 403);
            }

            $chat->status = 'active';
            $chat->admin_id = $user->admin_id;
            $chat->accepted_at = now();
            $chat->save();

            return response()->json([
                'success' => true,
                'info' => 'Chat accepted'
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

    public function endChat(Request $request)
    {
        try {
            // Check if got logged in
            if (!Auth::guard('admin')->check()) {
                return response()->json(['success' => false, 'info' => 'Unauthorized'], 403);
            }

            $user = Auth::guard('admin')->user();

            // Validate the request data for chat_id
            $request->validate([
                'chat_id' => 'required|integer',
            ]);

            $chat_id = $request->chat_id;

            // Get the chat
            $chat = Chat::find($chat_id);

            if (!$chat) {
                return response()->json(['success' => false, 'info' => 'Chat not found'], 404);
            }

            if ($chat->status != 'active') {
                return response()->json(['success' => false, 'info' => 'Chat cannot be end'], 400);
            }

            if (Gate::forUser($user)->denies('endChat', $chat)) {
                return response()->json(['success' => false, 'info' => 'You are not allowed to end this chat.'], 403);
            }

            $chat->status = 'ended';
            $chat->ended_at = now();
            $chat->save();

            //append to xml
            $xml_data = $this->getXmlRequiredData($chat);
            $xmlPath = storage_path('app/xml/chat.xml');
            $dom = new DOMDocument();
            $dom->formatOutput = true;

            if (!file_exists($xmlPath)) {
                Log::info('Creating new xml file');
                $root = $dom->createElement('chatCollection');
                $dom->appendChild($root);
            } else {
                Log::info('File found');
                $dom->load($xmlPath);
            }

            if ($this->addChatDataToXml($dom, $xml_data)) {
                $dom->save($xmlPath);
            }

            return response()->json([
                'success' => true,
                'info' => 'Chat ended'
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

    public function createChat()
    {
        try {

            // Check if got logged in
            if (!Auth::guard('customer')->check()) {
                return response()->json(['success' => false, 'info' => 'Unauthorized'], 403);
            }

            $user = Auth::guard('customer')->user();

            if (Gate::forUser($user)->denies('createChat')) {
                return response()->json(['success' => false, 'info' => 'You are not allowed to create chat.'], 403);
            }

            $customer_id = $user->customer_id;

            // Check if the user have an active/pending chat
            $active_chat = Chat::where('customer_id', $customer_id)->whereIn('status', ['active', 'pending'])->first();

            if ($active_chat) {
                return response()->json([
                    'success' => false,
                    'info' => 'You already have an ongoing chat'
                ], 400);
            }

            $chat = new Chat();
            $chat->customer_id = $customer_id;
            $chat->status = 'pending';
            $chat->save();

            $new_chat = Chat::where('customer_id', $customer_id)->where('status', 'pending')->first();

            if ($new_chat) {
                return response()->json([
                    'success' => true,
                    'info' => 'Chat created, waiting for admin to accept',
                    'chat_id' => $new_chat->chat_id
                ], 200);
            }
            return response()->json([
                'success' => false,
                'info' => 'Please try again later.'
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'info' => $e->getMessage()
            ], 500);
        }
    }

    public function rateChat(Request $request)
    {
        try {
            // Check if got logged in
            if (!Auth::guard('customer')->check()) {
                return response()->json(['success' => false, 'info' => 'Unauthorized'], 403);
            }

            $user = Auth::guard('customer')->user();

            // Validate the request data for chat_id
            $request->validate([
                'chat_id' => 'required|integer',
                'rate' => 'required|integer|between:1,5',
            ]);

            $chat_id = $request->chat_id;
            $rating = $request->rate;

            // Get the chat
            $chat = Chat::find($chat_id);

            if (!$chat) {
                return response()->json(['success' => false, 'info' => 'Chat not found'], 404);
            }

            if ($chat->status != 'ended') {
                return response()->json(['success' => false, 'info' => 'Chat is not ended'], 400);
            }

            if (Gate::forUser($user)->denies('rateChat', $chat)) {
                return response()->json(['success' => false, 'info' => 'You are not allowed to rate this chat.'], 403);
            }

            $chat->rating = $rating;
            $chat->save();

            //append to xml
            $xmlPath = storage_path('app/xml/chat.xml');
            $dom = new DOMDocument();
            $dom->formatOutput = true;

            if (!file_exists($xmlPath)) {
                return response()->json([
                    'success' => false,
                    'info' => 'File not found'
                ], 422);
            } 

            $dom->load($xmlPath);
            // Update the respective XML record
            $this->updateChatRatingInXml($dom, $chat_id, $rating);
            $dom->save($xmlPath);

            return response()->json([
                'success' => true,
                'info' => 'Chat rated'
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

    private function getXmlRequiredData(Chat $chat)
    {
        $admin = Admin::find($chat->admin_id);
        $customer = Customer::find($chat->customer_id);

        if (!$admin || !$customer) {
            return [];
        }

        return [
            'chat_id' => $chat->chat_id,
            'admin' => [
                'name' => $admin->name,
                'id' => $admin->admin_id,
            ],
            'customer' => [
                'name' => $customer->username,
                'id' => $customer->customer_id,
            ],
            'rating' => $chat->rating,
            'accepted_at' => $chat->accepted_at,
            'created_at' => $chat->created_at,
            'ended_at' => $chat->ended_at,
        ];
    }


    private function addChatDataToXml(DOMDocument $dom, array $chatData)
    {
        try {
            $root = $dom->documentElement;

            $chatElement = $dom->createElement('chat');
            $chatElement->setAttribute('chat_id', $chatData['chat_id']);

            $adminElement = $dom->createElement('admin');
            $adminNameElement = $dom->createElement('name', $chatData['admin']['name']);
            $adminIdElement = $dom->createElement('id', $chatData['admin']['id']);
            $adminElement->appendChild($adminNameElement);
            $adminElement->appendChild($adminIdElement);
            $chatElement->appendChild($adminElement);

            $customerElement = $dom->createElement('customer');
            $customerNameElement = $dom->createElement('name', $chatData['customer']['name']);
            $customerIdElement = $dom->createElement('id', $chatData['customer']['id']);
            $customerElement->appendChild($customerNameElement);
            $customerElement->appendChild($customerIdElement);
            $chatElement->appendChild($customerElement);

            $rating = is_null($chatData['rating']) ? 0 : $chatData['rating'];
            $ratingElement = $dom->createElement('rating', $rating);
            $chatElement->appendChild($ratingElement);

            $acceptedAtElement = $dom->createElement('accepted_at', $chatData['accepted_at']);
            $chatElement->appendChild($acceptedAtElement);

            $createdAtElement = $dom->createElement('created_at', $chatData['created_at']);
            $chatElement->appendChild($createdAtElement);

            $endedAtElement = $dom->createElement('ended_at', $chatData['ended_at']);
            $chatElement->appendChild($endedAtElement);

            $root->appendChild($chatElement);

            return true;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    private function updateChatRatingInXml(DOMDocument $dom, $chatId, $newRating)
    {
        try {
            $xpath = new \DOMXPath($dom);
            $chatElement = $xpath->query("//chat[@chat_id = '$chatId']")->item(0);

            if ($chatElement) {
                $ratingElement = $chatElement->getElementsByTagName('rating')->item(0);

                if ($ratingElement) {
                    $ratingElement->nodeValue = is_null($newRating) ? '0' : $newRating;
                } else {
                    $ratingElement = $dom->createElement('rating', is_null($newRating) ? '0' : $newRating);
                    $chatElement->appendChild($ratingElement);
                }

                return true;
            } else {
                Log::error("Chat with ID $chatId not found in XML.");
                return false;
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }
}
