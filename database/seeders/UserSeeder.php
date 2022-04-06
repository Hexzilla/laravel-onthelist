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
    }
}
