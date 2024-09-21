<?php
// Author: Loo Wee Kiat & Loh Thiam Wei
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable implements UserInterface
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
