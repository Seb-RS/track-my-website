<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PingResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'web_id',
        'status_code',
        'created_at'
    ];
}
