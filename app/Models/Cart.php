<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'cart';

    protected $primaryKey = 'customer_id';

    protected $fillable = [
        'customer_id',
        'subtotal',
        'total_discount',
        'total',
    ];

    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'customer_id', 'customer_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }
}
