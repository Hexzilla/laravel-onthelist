<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'client_id',
        'client_time',
        'venue',
        'event_id',
        'event_name',
        'event_type',
        'type',
        'price',
        'date',
        'status'
    ];

    public function User() {
        return $this->belongTo(User::class);
    }

    public function event() {
        return $this->belongTo(Event::class);
    }
}
