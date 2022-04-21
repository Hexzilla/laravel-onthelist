<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'image_path',
        'gender',
        'date_birth',
        'address',
        'phone'
    ];

    public function user()
    {
        $this->belongsTo(User::class);
    }
}
