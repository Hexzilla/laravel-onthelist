<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorAffiliate extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'affiliate_code',
        'referral_fee',
        'additional_notes'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
