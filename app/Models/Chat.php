<?php
// Author: Loh Thiam Wei
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $table = 'chat';

    protected $primaryKey = 'chat_id';

    public $timestamps = false;

    protected $fillable = [
        'customer_id',
        'admin_id',
        'status',
        'accepted_at',
        'ended_at',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'admin_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }

    public function chatMessages()
    {
        return $this->hasMany(ChatMessage::class, 'chat_id', 'chat_id');
    }
}
