<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        User::truncate();
        Schema::enableForeignKeyConstraints();
        
        User::create([
            'name' => "Vendor",
            'email' => "vendor@onthelist.app",
            'email_verified_at' => date('Y-m-d H:i:s'),
            'role' => "vendor",
            'password' => Hash::make('vendor123'),
            'remember_token' => Str::random(10),
        ]);

        User::create([
            'name' => 'Ronalonia',
            'email' => 'ronalonia@onthelist.app',
            'email_verified_at' => date('Y-m-d H:i:s'),
            'role' => "dj",
            'password' => Hash::make('ronalonia123'),
            'remember_token' => Str::random(10),
        ]);

        User::create([
            'name' => 'John James',
            'email' => 'james@onthelist.app',
            'email_verified_at' => date('Y-m-d H:i:s'),
            'role' => "dj",
            'password' => Hash::make('james123'),
            'remember_token' => Str::random(10),
        ]);

        User::create([
            'name' => 'Tommy Jackson',
            'email' => 'jackson@onthelist.app',
            'email_verified_at' => date('Y-m-d H:i:s'),
            'role' => "dj",
            'password' => Hash::make('jackson123'),
            'remember_token' => Str::random(10),
        ]);

        for ($i = 1; $i <= 100; $i++) {
            User::create([
                'name' => "Vendor" . $i,
                'email' => "vendor". $i . "@onthelist.app",
                'email_verified_at' => date('Y-m-d H:i:s'),
                'role' => "vendor",
                'password' => Hash::make('vendor123'),
                'remember_token' => Str::random(10),
            ]);
        }

        User::create([
            'name' => 'User',
            'email' => 'user@onthelist.app',
            'email_verified_at' => date('Y-m-d H:i:s'),
            'role' => 'customer',
            'password' => Hash::make('djs123'),
            'remember_token' => Str::random(10),
        ]);
    }
}
