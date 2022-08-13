<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
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
        'two_factor_recovery_codes',
        'two_factor_secret',
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

    public function userProfile()
    {
        return $this->hasOne(UserProfile::class);
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

    public function payment_cards()
    {
        return $this->hasMany(PaymentCard::class);
    }

    public function stripeAccount()
    {
        return $this->hasOne(StripeAccount::class);
    }

    public function stripeOptions(array $options = [])
    {
        $stripeAccount = $this->stripeAccount()->stripeAccount;

        if ($stripeAccount->secret) {
            $options['api_key'] = $stripeAccount->secret;
        }

        return Cashier::stripeOptions($options);
    }
}
