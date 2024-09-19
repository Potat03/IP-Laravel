<?php

// app/States/Order/DeliveryState.php

namespace App\States;
use App\Models\Order;
use App\States\DeliveredState;

class DeliveryState extends OrderState
{

    public function proceedToNext()
    {
        // Transition to DeliveredState
        $this->order->status = "delivered";
        $this->order->updated_at = now();
        $this->order->save();
        $this->order->changeState(new DeliveredState($this->order));
    }

    public function generateTrackingNumber():string
    {
        return null;
    }

    public function receiveOrder(): bool
    {
        return false; // Cannot rate in delivery state
    }
}
