<?php

namespace App\Messages;

use App\Services\ChatMessageService;

class ImageMessage implements MessageInterface
{
    protected $data;
    private $chatMessageService;

    public function __construct(object $data)
    {
        $this->data = $data;
        $this->chatMessageService = new ChatMessageService();
    }

    public function getContent(): array
    {
        $image_url = $this->chatMessageService->getImageMessagePath($this->data->chat_id, $this->data->message_content);

        if(!$image_url) {
            return [];
        }

        return [
            'type' => 'IMAGE',
            'image_url' => $image_url,
            'by_customer'=> $this->data->by_customer
        ];
    }
}