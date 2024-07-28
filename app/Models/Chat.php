<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $table = 'chat';

    protected $primaryKey = 'chat_id';

    protected $fillable = [
        'customer_id',
        'admin_id',
        'status',
        'created_at',
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

    public function chatState()
    {
        return $this->hasMany(ChatState::class, 'status', 'status_id');
    }
}
