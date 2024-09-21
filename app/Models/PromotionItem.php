<?php
//Author : Nicholas Yap Jia Wey
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromotionItem extends Model
{
    use HasFactory;

    protected $table = 'promotion_item';

    protected $primaryKey = 'id';

    protected $fillable = [
        'promotion_id',
        'product_id',
        'quantity',
    ];

    public function promotion()
    {
        return $this->belongsTo(Promotion::class, 'promotion_id', 'promotion_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
}
