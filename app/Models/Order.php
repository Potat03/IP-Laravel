<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//for state design pattern 
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
        'created_at',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'order_id', 'order_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'order_id');
    }

    public function orderState()
    {
        return $this->hasOne(OrderState::class, 'order_id', 'order_id');
    }


    //for state design pattern
    protected $state;

    public function __construct()
    {
        $this->state = new PrepareState($this);  // Initialize with PrepareState
    }

    // Method to change state
    public function changeState(OrderState $state)
    {
        $this->state = $state;
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

    public function rateOrder()
    {
        return $this->state->canRateOrder();
    }

    // Additional methods that states may call
    public function generateDeliveryCode()
    {
        // Generate delivery code logic
        return 'DEL' . uniqid();
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
    
}
