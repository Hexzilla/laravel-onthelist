<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AffiliateProgram extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','code', 'referral_fee', 'additional_note'
    ];
}
