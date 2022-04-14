<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use App\Models\EventDj;

class EventDjSeeder extends Seeder
{
     /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        EventDj::truncate();
        Schema::enableForeignKeyConstraints();

        EventDj::create([
            'dj_id' => 1,
            'event_id' => 1,
        ]);

        EventDj::create([
            'dj_id' => 2,
            'event_id' => 2,
        ]);

        EventDj::create([
            'dj_id' => 3,
            'event_id' => 3,
        ]);
    }
}
