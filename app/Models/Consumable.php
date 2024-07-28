<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consumable extends Model
{
    use HasFactory;

    protected $table = 'consumable';

    protected $primaryKey = 'product_id';

    protected $fillable = [
        'product_id',
        'expire_date',
        'portion',
        'is_halal'
    ];

    public function Product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
}
