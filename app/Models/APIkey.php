<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class APIkey extends Model
{
    use HasFactory;

    protected $table = 'api_keys';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'api_key',
        'note',
    ];

    protected $dates = ['created_at'];
}
