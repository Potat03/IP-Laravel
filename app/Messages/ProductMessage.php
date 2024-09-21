<?php
// Author: Loh Thiam Wei
namespace App\Messages;

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

        if(!$product || !$image_url) {
            return [];
        }

        return [
            'type' => 'PRODUCT',
            'image' => $image_url,
            'id' => $product->product_id,
            'name' => $product->name,
            'by_customer'=> $this->data->by_customer,
            'message_id'=> $this->data->message_id
        ];
    }
}