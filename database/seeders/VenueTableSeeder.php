<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use App\Models\VenueTable;

class VenueTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        VenueTable::truncate();
        Schema::enableForeignKeyConstraints();

        VenueTable::create([
            'venue_id' => 1,
            'type' => 'Type 2',
            'qty' => 30,
            'price' => 25,
            'approval' => 'Yes',
        ]);
    }
}
