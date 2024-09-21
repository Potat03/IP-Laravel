<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory;

    protected $table = 'admin';

    protected $primaryKey = 'admin_id';

    protected $fillable = [
        'role',
        'name',
        'email',
        'password',
        'session_id',
        'status'
    ];

    protected $guarded = [
        'remember_token',
    ];

    public function chats()
    {
        return $this->hasMany(Chat::class, 'admin_id', 'admin_id');
    }

    public function adminLogs()
    {
        return $this->hasMany(AdminLog::class, 'admin_id', 'admin_id');
    }

    public function verification()
    {
        return $this->hasOne(AdminVerification::class, 'admin_id', 'admin_id');
    }

    public function getId() {
        return $this->admin_id;
    }

    public function getRole() {
        return $this->role;
    }

    public function getStatus() {
        return $this->status;
    }
}
