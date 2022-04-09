<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DjProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'age',
        'genres',
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
