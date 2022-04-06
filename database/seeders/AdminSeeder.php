<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::truncate();
        Admin::create([
            'name' => "Admin",
            'email' => "admin@onthelist.app",
            'password' => Hash::make('admin123'),
            'remember_token' => Str::random(10),
        ]);
    }
}
