<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $table = 'rating';

    // protected $primaryKey = ['product_id', 'customer_id'];
    protected $primaryKey = 'id';

    protected $fillable = [
        'product_id',
        'customer_id',
        'rating',
        'description',
        'created_at',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
}
