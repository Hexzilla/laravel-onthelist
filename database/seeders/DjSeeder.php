<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use App\Models\Dj;

class DjSeeder extends Seeder
{
     /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        Dj::truncate();
        Schema::enableForeignKeyConstraints();

        Dj::create([
            'user_id' => 2,
            'description' => 'Top performance coach',
            'mixcloud_link' => 'https://maxcloud.com/ronalonia',
            'header_image_path' => 'images/download_now_bg.jpg',
            'genre' => 'performance',
            'vendor_id' => 1,
        ]);

        Dj::create([
            'user_id' => 3,
            'description' => 'Top 1 Music Player',
            'mixcloud_link' => 'https://maxcloud.com/john',
            'header_image_path' => 'images/dj.jpg',
            'genre' => 'Music',
            'vendor_id' => 1,
        ]);

        Dj::create([
            'user_id' => 4,
            'description' => 'Web Designer',
            'mixcloud_link' => 'https://maxcloud.com/tommy',
            'header_image_path' => 'images/download_now_bg.jpg',
            'genre' => 'IT',
            'vendor_id' => 1,
        ]);
    }
}
