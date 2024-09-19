<?php

namespace App\States;

use App\Models\Order;

class DeliveredState extends OrderState
{
    public function proceedToNext()
    {
        //do nothing
    }


    public function generateTrackingNumber():string
    {
        return null;
    }

    public function receiveOrder(): bool
    {
        $this->order->received = true;
        $this->order->save();
        return true; 
    }
}