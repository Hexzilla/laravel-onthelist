<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "type",
        "description",
        "header_image_path",
        "address",
        "city",
        "postcode",
        "phone",
        "facilities",
        "music_policy",
        "dress_code",
        "perks",
        "status",
        "featured",
    ];

    protected $appends = ["location"];

    public function timetable()
    {
        return $this->hasOne(VenueTimetable::class);
    }

    public function tables()
    {
        return $this->hasMany(VenueTable::class);
    }

    public function offers()
    {
        return $this->hasMany(VenueOffer::class);
    }

    public function media()
    {
        return $this->hasMany(VenueMedia::class);
    }

    public function getLocationAttribute()
    {
        return $this->address . ', ' . $this->city . ', ' . $this->postcode;
    }

    public function isApproved()
    {
        return $this->status == "Approved" ? true : false;
    }

    public function messages()
    {
        return $this->hasMany(VenueMessage::class);
    }
}
