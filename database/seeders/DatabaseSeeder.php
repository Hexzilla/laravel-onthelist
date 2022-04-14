<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            AdminSeeder::class,
            VenueSeeder::class,
            EventSeeder::class,            
            BookingSeeder::class,
            TimetableSeeder::class,
            EventTicketsSeeder::class,
            EventTableSeeder::class,
            EventGuestlistSeeder::class,
            VenueOfferSeeder::class,
            VenueTableSeeder::class,
            DjSeeder::class,
            EventDjSeeder::class,
        ]);
    }
}
