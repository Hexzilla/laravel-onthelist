<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DjMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'dj_id',
        'message'
    ];
}
