<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderState extends Model
{
    use HasFactory;

    protected $table = 'order_state';

    protected $primaryKey = 'order_id';

    protected $fillable = [
        'order_id',
        'status',
        'current_location',
        'description',
        'created_at'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }
}
