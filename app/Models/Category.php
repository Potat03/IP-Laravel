<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'category';

    protected $primaryKey = 'category_name';

    protected $fillable = [
        'category_name',
        'description',
    ];

    public function Product()
    {
        return $this->belongsToMany(Product::class, 'product_category', 'category_name', 'product_id');
    }
}
