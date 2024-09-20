<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminVerification extends Model
{
    use HasFactory;

    protected $table = 'adminverification';

    protected $primaryKey = 'id';

    protected $fillable = [
        'admin_id',
        'code',
        'status',
        'expired_date',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'admin_id');
    }
}
