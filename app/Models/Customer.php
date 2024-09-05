<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customer';

    protected $primaryKey = 'customer_id';

    protected $fillable = [
        'customer_id',
        'username', 
        'tier', 
        'phone_number',
        'email',
        'password',
        'status',
        'created_at',
    ];

    public function Order()
    {
        return $this->hasMany(Order::class, 'customer_id', 'customer_id');
    }

    public function Cart()
    {
        return $this->hasOne(Cart::class, 'customer_id', 'customer_id');
    }

    public function Chat()
    {
        return $this->hasMany(Chat::class, 'customer_id', 'customer_id');
    }

    public function Verification()
    {
        return $this->hasMany(Verification::class, 'customer_id', 'customer_id');
    }
}
