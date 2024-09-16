<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ChatMessageService
{
    public function getMainProductImagePath($id)
    {
        $extensions = ['png', 'jpg', 'jpeg'];
        $imagePath = null;

        foreach ($extensions as $ext) {
            $filePath = "images/products/{$id}/main.{$ext}";
            if (Storage::disk('public')->exists($filePath)) {
                $imagePath = asset("storage/{$filePath}");
                break;
            }
        }
        return $imagePath;
    }

    public function getProductDetails($id)
    {
        $product = Product::find($id);
        return $product;
    }

    public function getImageMessagePath($chat_id, $message_id)
    {
        $extensions = ['png', 'jpg', 'jpeg'];
        $imagePath = null;

        foreach ($extensions as $ext) {
            $filePath = "images/chat/{$chat_id}/{$message_id}.{$ext}";
            if (Storage::disk('public')->exists($filePath)) {
                $imagePath = asset("storage/{$filePath}");
                break;
            }
        }
        return $imagePath;
    }

    public function uploadImageMessage($chat_id, $message_id, $image)
    {
        $extensions = ['png', 'jpg', 'jpeg'];
        $imagePath = null;

        foreach ($extensions as $ext) {
            $filePath = "images/chat/{$chat_id}/{$message_id}.{$ext}";
            if (Storage::disk('public')->put($filePath, $image)) {
                $imagePath = asset("storage/{$filePath}");
                break;
            }
        }
        return $imagePath;
    }
}
