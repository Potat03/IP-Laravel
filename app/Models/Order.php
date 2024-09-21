<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\States\OrderState;
use App\States\PrepareState;
use App\States\DeliveryState;
use App\States\DeliveredState;

class Order extends Model
{
    use HasFactory;

    protected $table = 'order';

    protected $primaryKey = 'order_id';

    protected $fillable = [
        'order_id',
        'customer_id',
        'subtotal',
        'total_discount',
        'total',
        'status',
        'delivery_address',
        'delivery_method',
        'tracking_number',
        'rating',
        'created_at',
    ];

    protected $state;

    public static function boot()
    {
        parent::boot();

        // Hook into the retrieved event to set the state after the model is loaded
        static::retrieved(function ($order) {
            $order->setState();
        });
    }

    // Set the appropriate state based on the status
    public function setState()
    {
        switch ($this->status) {
            case 'prepare':
                $this->state = new PrepareState($this);
                break;

            case 'delivery':
                $this->state = new DeliveryState($this);
                break;

            case 'delivered':
                $this->state = new DeliveredState($this);
                break;

            default:
                // Default state can be PrepareState, or handle undefined status
                $this->state = new PrepareState($this);
                break;
        }
    }

    // Method to change state
    public function changeState(OrderState $state)
    {
        $this->state = $state;
        $this->save();
    }

    // Delegates to the state
    public function proceedToNext()
    {
        $this->state->proceedToNext();
    }

    public function showOrder()
    {
        return $this->state->canShowToUser();
    }

    public function receiveOrder()
    {
        return $this->state->receiveOrder();
    }

    public function startDelivery()
    {
        // Logic for starting delivery
    }

    public function markAsDelivered()
    {
        // Logic for marking order as delivered
    }

    public function enableRating()
    {
        // Logic to enable user rating
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'order_id');
    }
}
