<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use App\Models\Venue;

class VenueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        Venue::truncate();
        Schema::enableForeignKeyConstraints();

        Venue::create([
            'user_id' => 1,
            'name' => 'Picture Palace Hall',
            'header_image_path' => 'images/event.jpg',
            'type' => 'Type 1',
            'address' => '123',
            'city' => 'London',
            'postcode' => '123456',
            'phone' => '1234567890',
            'status' => 'Approved',
        ]);

        Venue::create([
            'user_id' => 1,
            'name' => 'Laravel Hall',
            'header_image_path' => 'images/event.jpg',
            'type' => 'Type 1',
            'address' => '456',
            'city' => 'London',
            'postcode' => '123456',
            'phone' => '1234567890',
            'status' => 'Approved',
        ]);
    }
}
