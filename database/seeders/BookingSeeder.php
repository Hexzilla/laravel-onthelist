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

        for ($i = 0; $i < 100; $i++) {
            Booking::create([
                'user_id' => 3,
                'event_id' => 1,
                'type' => 'Table Booking',
                'price' => '500',
                'status' => 'Pending',
                'date' => '2022-04-12',
            ]);
        }
    }
}
