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
        if(!$product) {
            return null;
        }
        return $product;
    }

    public function getImageMessagePath($chat_id, $image_name)
    {
        $filePath = "images/chats/{$chat_id}/{$image_name}";
        if (Storage::disk('public')->exists($filePath)) {
            return  asset("storage/{$filePath}");
        }
        return null;
    }
}
