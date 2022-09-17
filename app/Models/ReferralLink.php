<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferralLink extends Model
{
    use HasFactory;

    protected $fillable = ['referral_program_id', 'user_id', 'code', 'referral_fee', 'additional_notes'];

    public function getLinkAttribute()
    {
        return url($this->program->uri) . '?ref=' . $this->code;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function program()
    {
        // TODO: Check if second argument is required
        return $this->belongsTo(ReferralProgram::class, 'referral_program_id');
    }

    public function relationships()
    {
        return $this->hasMany(ReferralRelationship::class);
    }
}
