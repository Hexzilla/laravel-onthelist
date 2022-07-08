<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\DjModel;

class Dj extends Model
{
    use HasFactory;

    protected $fillable = [
        "vendor_id",
        "description",
        "mixcloud_link",
        "header_image_path",
        "user_id",
        "genre",
    ];

    public function media()
    {
        return $this->hasMany(DjMedia::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function messages()
    {
        return $this->hasMany(DjMessage::class);
    }
}
