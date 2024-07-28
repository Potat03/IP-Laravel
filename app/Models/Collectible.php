<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collectible extends Model
{
    use HasFactory;

    protected $table = 'collectible';

    protected $primaryKey = 'product_id';

    protected $fillable = [
        'product_id',
        'supplier',
    ];

    public function Product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }

}
