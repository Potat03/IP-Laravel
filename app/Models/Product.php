<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'product';

    protected $primaryKey = 'product_id';

    protected $fillable = [
        'product_id',
        'name',
        'description',
        'price',
        'stock',
        'created_at'
    ];

    public function collectible()
    {
        return $this->hasOne(Collectible::class, 'product_id', 'product_id');
    }

    public function consumable()
    {
        return $this->hasOne(Consumable::class, 'product_id', 'product_id');
    }

    public function wearable()
    {
        return $this->hasOne(Wearable::class, 'product_id', 'product_id');
    }

    public function rating()
    {
        return $this->hasMany(Rating::class, 'product_id', 'product_id');
    }

    public function cartItems()
    {
        return $this->belongsToMany(CartItem::class, 'product_id', 'product_id');
    }

    public function orderItems()
    {
        return $this->belongsToMany(OrderItem::class, 'product_id', 'product_id');
    }

    public function promotionItems()
    {
        return $this->belongsToMany(PromotionItem::class, 'product_id', 'product_id');
    }

    public function promotion()
    {
        return $this->belongsToMany(Promotion::class, 'promotion_item', 'product_id', 'promotion_id');
    }

    public function category()
    {
        return $this->belongsToMany(Category::class, 'product_categories', 'product_id', 'category_name');
    }
}
