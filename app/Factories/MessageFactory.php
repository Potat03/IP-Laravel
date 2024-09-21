<?php
// Author: Loh Thiam Wei
namespace App\Factories;


use App\Messages\ProductMessage;
use App\Messages\NormalMessage;
use App\Messages\ImageMessage;
use App\Messages\MessageInterface;

class MessageFactory
{
    public static function create(object $messageData): MessageInterface
    {
        return match(strtoupper($messageData->message_type)) {
            'TEXT' => new NormalMessage($messageData),
            'IMAGE' => new ImageMessage($messageData),
            'PRODUCT' => new ProductMessage($messageData),
            default => throw new \InvalidArgumentException('Invalid Message'),
        };
    }
}