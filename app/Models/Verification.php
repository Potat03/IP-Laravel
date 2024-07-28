<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Verification extends Model
{
    use HasFactory;

    protected $table = 'verification';

    protected $primaryKey = ['customer_id', 'code', 'created_at'];

    protected $fillable = [
        'customer_id',
        'code',
        'status',
        'created_at',
        'expired_at',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }
}
