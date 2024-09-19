<?php

namespace App\States;

use App\Models\Order;

abstract class OrderState
{
    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    abstract public function proceedToNext();
    abstract public function generateTrackingNumber(): string;
    abstract public function receiveOrder(): bool;
}
