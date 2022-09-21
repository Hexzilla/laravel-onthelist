<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "type",
        "venue_id",
        "description",
        "header_image_path",
        "start",
        "end",
        "is_weekly_event",        
        "status"
    ];

    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }

    public function guestlists()
    {
        return $this->hasMany(EventGuestlist::class);
    }

    public function tables()
    {
        return $this->hasMany(EventTable::class);
    }

    public function tickets()
    {
        return $this->hasMany(EventTicket::class);
    }

    public function media()
    {
        return $this->hasMany(EventMedia::class);
    }

    public function djs()
    {
        return $this->hasMany(EventDj::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function isApproved()
    {
        return $this->status == "Approved" ? true : false;
    }

    public function messages()
    {
        return $this->hasMany(EventMessage::class);
    }
}
