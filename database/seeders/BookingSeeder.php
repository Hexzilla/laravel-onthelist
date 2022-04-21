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

        for ($i = 0; $i < 30; $i++) {
            Booking::create([
                'user_id' => 3,
                'event_id' => 1,
                'booking_type' => 'Table Booking',
                'type' => 'EarlyBird',
                'qty' => '1',
                'price' => '500',
                'status' => 'Pending',
                'date' => '2022-04-12',
            ]);

            Booking::create([
                'user_id' => 1,
                'event_id' => 2,
                'booking_type' => 'Ticket',
                'type' => 'EarlyBird',
                'qty' => '1',
                'price' => '25',
                'status' => 'Pending',
                'date' => '2022-04-12',
            ]);

            Booking::create([
                'user_id' => 3,
                'event_id' => 3,
                'booking_type' => 'Guestlist',
                'type' => 'VIP',
                'qty' => '1',
                'price' => '100',
                'status' => 'Pending',
                'date' => '2022-04-12',
            ]);
        }
    }
}
