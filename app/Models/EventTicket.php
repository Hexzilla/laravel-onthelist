<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventTicket extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'type',
        'qty',
        'price',
        'approval',
        'description'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
