<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use App\Models\VenueOffer;

class VenueOfferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        VenueOffer::truncate();
        Schema::enableForeignKeyConstraints();

        VenueOffer::create([
            'venue_id' => 1,
            'type' => 'Type 2',
            'qty' => 30,
            'price' => 25,
            'approval' => 'Yes',
        ]);
    }
}
