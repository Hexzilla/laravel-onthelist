<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'type',
        'ticket_code',
        'ticket_img_url',
        'is_scanned',
    ];
}
