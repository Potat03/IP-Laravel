<?php

namespace App\Messages;

class ImageMessage implements MessageInterface
{
    protected $data;

    public function __construct(object $data)
    {
        $this->data = $data;
    }

    public function getContent(): array
    {
        return [
            'type' => 'image',
            'image_url' => $this->data->image_url
        ];
    }
}