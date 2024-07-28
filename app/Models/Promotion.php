<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    protected $table = 'promotion';

    protected $primaryKey = 'promotion_id';

    protected $fillable = [
        'promotion_id',
        'title',
        'description',
        'discount',
        'type',
        'limit',
        'start_at',
        'end_at',
    ];

    public function orderItem()
    {
        return $this->belongsToMany(OrderItem::class, 'promotion_id', 'promotion_id');
    }

    public function cartItem()
    {
        return $this->belongsToMany(CartItem::class, 'promotion_id', 'promotion_id');
    }

    public function product()
    {
        return $this->belongsToMany(Product::class, 'promotion_item', 'promotion_id', 'product_id');
    }

    public function promotionItem()
    {
        return $this->hasMany(PromotionItem::class, 'promotion_id', 'promotion_id');
    }
}
