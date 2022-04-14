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
            'name' => 'Ronalonia',
            'description' => 'Top performance coach',
            'mixcloud_link' => 'https://maxcloud.com/ronalonia',
            'genre' => 'performance',
            'user_id' => 1,
        ]);

        Dj::create([
            'name' => 'John James',
            'description' => 'Top 1 Music Player',
            'mixcloud_link' => 'https://maxcloud.com/john',
            'genre' => 'Music',
            'user_id' => 1,
        ]);

        Dj::create([
            'name' => 'Tommy Jackson',
            'description' => 'Web Designer',
            'mixcloud_link' => 'https://maxcloud.com/tommy',
            'genre' => 'IT',
            'user_id' => 1,
        ]);
    }
}
