<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dj extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "description",
        "mixcloud_link",
        "header_image_path",
        "user_id",
        "genre",
    ];

}
