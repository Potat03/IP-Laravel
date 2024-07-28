<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wearable extends Model
{
    use HasFactory;

    protected $table = 'wearable';

    protected $primaryKey = 'product_id';

    protected $fillable = [
        'product_id',
        'size',
        'color',
        'user_group',
    ];

    public function Product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
}

