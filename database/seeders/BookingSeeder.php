<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use App\Models\Booking;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        Booking::truncate();
        Schema::enableForeignKeyConstraints();

        Booking::create([
            'user_id' => 1,
            'client_id' => 3,
            'client_name' => 'User',
            'venue' => 'Picture Palace Hall, London',
            'event_id' => 1,
            'event_name' => 'Party Nonstop',
            'event_type' => 'Private',
            'type' => 'Table Booking',
            'price' => '500',
            'status' => 'Pending',
            'date' => '2022-04-12',
        ]);
    }
}
