<?php

namespace App\States;
use App\States\DeliveryState;
use App\Models\Order;


class PrepareState extends OrderState
{
    private $tracking_number;

    public function proceedToNext()
    {
        // Transition to DeliveryState
        $this->tracking_number = $this->generateTrackingNumber(); // Generate code
        $this->order->tracking_number = $this->tracking_number; // Save delivery code to DB
        $this->order->delivery_method = "POS";
        $this->order->status = "delivery";
        $this->order->updated_at = now();
        $this->order->save();
        $this->order->changeState(new DeliveryState($this->order));
    }

    public function generateTrackingNumber():string
    {
        // Generate delivery code logic
        return 'DEL' . uniqid();
    }

    public function receiveOrder(): bool
    {
        return false;  // Cannot rate in this state
    }
}
