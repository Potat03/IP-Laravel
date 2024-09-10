<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'chat_messages';

    protected $primaryKey = 'message_id';

    protected $fillable = [
        'chat_id',
        'by_customer',
        'message_content',
        'message_type'
    ];

    public function chat()
    {
        return $this->belongsTo(Chat::class, 'chat_id', 'chat_id');
    }
}
