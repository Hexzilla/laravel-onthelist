<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Following;
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
        Following::truncate();
        Schema::enableForeignKeyConstraints();
        
        $vendor = User::create([
            'name' => "Vendor",
            'email' => "vendor@onthelist.app",
            'email_verified_at' => date('Y-m-d H:i:s'),
            'role' => "vendor",
            'password' => Hash::make('vendor123'),
            'remember_token' => Str::random(10),
        ]);

        $customer = User::create([
            'name' => 'User',
            'email' => 'customer@onthelist.app',
            'email_verified_at' => date('Y-m-d H:i:s'),
            'role' => 'customer',
            'password' => Hash::make('customer123'),
            'remember_token' => Str::random(10),
        ]);

        Following::create([
            'user_id' => $customer->id,
            'following_user_id' => $vendor->id,
        ]);

        for ($i = 1; $i <= 30; $i++) {
            $vendor = User::create([
                'name' => "Vendor" . $i,
                'email' => "vendor". $i . "@onthelist.app",
                'email_verified_at' => date('Y-m-d H:i:s'),
                'role' => "vendor",
                'password' => Hash::make('vendor123'),
                'remember_token' => Str::random(10),
            ]);

            if ($i % 2 == 0) {
                Following::create([
                    'user_id' => $customer->id,
                    'following_user_id' => $vendor->id,
                ]);
            }
        }
    }
}
