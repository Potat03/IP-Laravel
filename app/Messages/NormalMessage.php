<?php
// Author: Loh Thiam Wei
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
            'type' => 'TEXT',
            'text' => $this->data->message_content,
            'by_customer'=> $this->data->by_customer,
            'message_id'=> $this->data->message_id
        ];
    }
}