<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use App\Models\User;
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

        $vendor = User::where('role', 'vendor')->firstOrFail();

        for ($i = 1; $i <= 15; $i++) {
            $user = User::create([
                'name' => 'jackson' . $i,
                'email' => 'jackson' . $i . '@onthelist.app',
                'email_verified_at' => date('Y-m-d H:i:s'),
                'role' => "dj",
                'password' => Hash::make('jackson123'),
                'remember_token' => Str::random(10),
            ]);
            Dj::create([
                'user_id' => $user->id,
                'description' => 'Top Pianist ' . $i,
                'mixcloud_link' => 'https://maxcloud.com/ronalonia' . $i,
                'header_image_path' => 'images/download_now_bg.jpg',
                'genre' => 'Music,Piano',
                'vendor_id' => $vendor->id,
            ]);
        }
    }
}
