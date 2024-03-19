<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PingResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'url',
        'status_code',
        'created_at'
    ];
}
