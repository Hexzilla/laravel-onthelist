<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use App\Models\Booking;
use App\Models\Ticket;

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
        Ticket::truncate();
        Schema::enableForeignKeyConstraints();

        for ($i = 0; $i < 30; $i++) {
            $booking = Booking::create([
                'user_id' => 1,
                'event_id' => 1,
                'booking_type' => 'Table',
                'qty' => 1,
                'type' => 'EarlyBird',
                'price' => '500',
                'status' => 'Pending',
                'date' => '2022-04-12',
            ]);

            Ticket::create([
                'member_id' => $booking->id,
                'type' => 'event',
                'ticket_code' => 'test',
                'ticket_img_url' => 'test',
                'is_scanned' => rand(0, 10) >= 5 ? 1 : 0,
            ]);

            $booking = Booking::create([
                'user_id' => 1,
                'event_id' => 2,
                'booking_type' => 'Ticket',
                'qty' => 1,
                'type' => 'EarlyBird',
                'price' => '25',
                'status' => 'Pending',
                'date' => '2022-04-12',
            ]);

            Ticket::create([
                'member_id' => $booking->id,
                'type' => 'event',
                'ticket_code' => 'test',
                'ticket_img_url' => 'test',
                'is_scanned' => rand(0, 10) >= 5 ? 1 : 0,
            ]);

            $booking = Booking::create([
                'user_id' => 1,
                'event_id' => 3,
                'booking_type' => 'Guestlist',
                'qty' => 1,
                'type' => 'VIP',
                'price' => '100',
                'status' => 'Pending',
                'date' => '2022-04-12',
            ]);

            Ticket::create([
                'member_id' => $booking->id,
                'type' => 'event',
                'ticket_code' => 'test',
                'ticket_img_url' => 'test',
                'is_scanned' => rand(0, 10) >= 5 ? 1 : 0,
            ]);
        }
    }
}
