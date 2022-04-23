<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'paused_at',
        'deleted_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function dj()
    {
        return $this->hasOne(Dj::class);
    }

    public function profile()
    {
        return $this->hasMany(DjProfile::class);
    }

    public function media()
    {
        return $this->hasMany(DjMedia::class);
    }

    public function booking()
    {
        return $this->hasMany(Booking::class);
    }

    public function vendor()
    {
        return $this->hasOne(Vendor::class);
    }

    public function favourite()
    {
        return $this->hasMany(UserFavourite::class);
    }
}
