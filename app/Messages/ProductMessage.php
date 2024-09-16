<?php

namespace App\Messages;

use App\Models\Product;
use App\Http\Controllers\ProductController;
use App\Services\ChatMessageService;

class ProductMessage implements MessageInterface
{
    private $data;
    private $chatMessageService;

    public function __construct(object $data)
    {
        $this->data = $data;
        $this->chatMessageService = new ChatMessageService();
    }

    public function getContent(): array
    {
        $product_id = $this->data->message_content;
        $product = $this->chatMessageService->getProductDetails($product_id);
        $image_url = $this->chatMessageService->getMainProductImagePath($product_id);

        return [
            'type' => 'product',
            'image' => $image_url,
            'name' => $product->name,
            'price' => $product->price,
        ];
    }
}