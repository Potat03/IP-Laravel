<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatState extends Model
{
    use HasFactory;

    protected $table = 'chat_state';

    protected $primaryKey = 'chat_id';

    protected $fillable = [
        'chat_id',
        'status',
        'created_at'
    ];

    public function chat()
    {
        return $this->belongsTo(Chat::class, 'chat_id', 'chat_id');
    }
}
