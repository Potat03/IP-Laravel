<!--Nicholas Yap Jia Wey-->
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderItem;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\PromotionItem;
use App\Memento\PromotionMemento;

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
        'discount_amount',
        'original_price',
        'type',
        'limit',
        'status',
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

    public function saveToMemento()
    {
        return new PromotionMemento(
            $this->promotion_id,
            $this->title,
            $this->description,
            $this->discount,
            $this->discount_amount,
            $this->original_price,
            $this->type,
            $this->limit,
            $this->status,
            $this->start_at,
            $this->end_at,
            $this->promotionItem()->get()
        );
    }

    public function restoreFromMemento(PromotionMemento $memento)
    {
        $this->promotion_id = $memento->getPromotion()['promotion_id'];
        $this->title = $memento->getPromotion()['title'];
        $this->description = $memento->getPromotion()['description'];
        $this->discount = $memento->getPromotion()['discount'];
        $this->discount_amount = $memento->getPromotion()['discount_amount'];
        $this->original_price = $memento->getPromotion()['original_price'];
        $this->type = $memento->getPromotion()['type'];
        $this->limit = $memento->getPromotion()['limit'];
        $this->status = $memento->getPromotion()['status'];
        $this->start_at = $memento->getPromotion()['start_at'];
        $this->end_at = $memento->getPromotion()['end_at'];
        $this->promotionItem()->delete();
        foreach ($memento->getPromotion()['product_list'] as $product) {
            $this->promotionItem()->create([
                'product_id' => $product['product_id'],
                'quantity' => $product['quantity'],
            ]);
        }
        $this->save();
    }
}
