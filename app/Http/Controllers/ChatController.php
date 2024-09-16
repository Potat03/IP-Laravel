<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use Illuminate\Http\Request;
use App\Services\ChatMessageService;

class ChatController extends Controller
{
    public function index()
    {
        return view('wei');
    }


    public function store(Request $request)
    {
        try {
            // Validate the request data
            $request->validate([
                'message' => 'required|string',
                'user_id' => 'required|integer',
            ]);
    
            // Create a new chat message
            $message = new ChatMessage();
            $message->message = $request->message;
            $message->chat_id = $request->user_id;
            $message->by_customer = 0;
            $message->save();
    
            // Return a JSON response with the saved message
            return response()->json([
                'message' => $message,
            ], 201); // Status code 201 Created
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation exceptions
            return response()->json([
                'error' => 'Validation error',
                'message' => $e->getMessage(),
                'errors' => $e->errors()
            ], 422); // Status code 422 Unprocessable Entity
    
        } catch (\Exception $e) {
            // Handle general exceptions
            return response()->json([
                'error' => 'Server error',
                'message' => $e->getMessage()
            ], 500); // Status code 500 Internal Server Error
        }
    }

    public function show($chatId)
    {
        $messages = ChatMessage::where('chat_id', $chatId)->get();

        return response()->json([
            'messages' => $messages,
        ]);
    }

    public function destroy($id)
    {
        $message = ChatMessage::find($id);

        if ($message) {
            $message->delete();
            return response()->json([
                'success' => true,
                'message' => 'Message deleted successfully',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Message not found',
        ], 404);
    }

}
