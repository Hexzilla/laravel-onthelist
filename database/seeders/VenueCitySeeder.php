<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use App\Models\VenueCity;

class VenueCitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        VenueCity::truncate();
        Schema::enableForeignKeyConstraints();

        VenueCity::create([
            'name' => 'London',
        ]);
    }
}
