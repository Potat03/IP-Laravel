<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    use HasFactory;

    protected $table = 'chat_message';

    protected $primaryKey = ['chat_id', 'by_customer', 'created_at'];

    protected $fillable = [
        'chat_id',
        'by_customer',
        'message',
        'created_at'
    ];

    public function chat()
    {
        return $this->belongsTo(Chat::class, 'chat_id', 'chat_id');
    }
}
