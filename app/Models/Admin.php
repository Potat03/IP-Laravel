<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    protected $table = 'admin';

    protected $primaryKey = 'admin_id';

    protected $fillable = [
        'role',
        'email',
        'password',
        'status',
    ];

    public function chats()
    {
        return $this->hasMany(Chat::class, 'admin_id', 'admin_id');
    }

    public function adminLogs()
    {
        return $this->hasMany(AdminLog::class, 'admin_id', 'admin_id');
    }
}
