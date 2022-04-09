<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use App\Models\VenueTimetable;

class TimetableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        VenueTimetable::truncate();
        Schema::enableForeignKeyConstraints();

        VenueTimetable::create([
            'venue_id' => 1,
            'mon_open' => '09:00',
            'mon_close' => '20:00',
            'tue_open' => '09:00',
            'tue_close' => '20:00',
            'wed_open' => '09:00',
            'wed_close' => '20:00',
            'thu_open' => '09:00',
            'thu_close' => '20:00',
            'fri_open' => '09:00',
            'fri_close' => '20:00',
            'sat_open' => '09:00',
            'sat_close' => '20:00',
            'sun_open' => '09:00',
            'sun_close' => '20:00'
        ]);
    }
}
