<?php

namespace App\Messages;

class NormalMessage implements MessageInterface
{
    protected $data;

    public function __construct(object $data)
    {
        $this->data = $data;
    }

    public function getContent(): array
    {
        return [
            'type' => 'text',
            'image_url' => $this->data->text
        ];
    }
}