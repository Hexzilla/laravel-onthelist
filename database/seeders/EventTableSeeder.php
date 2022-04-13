<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use App\Models\EventTable;

class EventTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        EventTable::truncate();
        Schema::enableForeignKeyConstraints();

        EventTable::create([
            'event_id' => 1,
            'type' => 'Standard',
            'qty' => 5,
            'price' => 200,
            'approval' => 'Yes',
        ]);

        EventTable::create([
            'event_id' => 1,
            'type' => 'EarlyBird',
            'qty' => 5,
            'price' => 150,
            'approval' => 'Yes',
        ]);

        EventTable::create([
            'event_id' => 1,
            'type' => 'VIP',
            'qty' => 5,
            'price' => 250,
            'approval' => 'Yes',
        ]);

        EventTable::create([
            'event_id' => 2,
            'type' => 'Standard',
            'qty' => 5,
            'price' => 400,
            'approval' => 'Yes',
        ]);

        EventTable::create([
            'event_id' => 2,
            'type' => 'EarlyBird',
            'qty' => 5,
            'price' => 300,
            'approval' => 'Yes',
        ]);

        EventTable::create([
            'event_id' => 2,
            'type' => 'VIP',
            'qty' => 5,
            'price' => 500,
            'approval' => 'Yes',
        ]);

        EventTable::create([
            'event_id' => 3,
            'type' => 'Standard',
            'qty' => 5,
            'price' => 300,
            'approval' => 'Yes',
        ]);

        EventTable::create([
            'event_id' => 3,
            'type' => 'EarlyBird',
            'qty' => 5,
            'price' => 250,
            'approval' => 'Yes',
        ]);

        EventTable::create([
            'event_id' => 3,
            'type' => 'VIP',
            'qty' => 5,
            'price' => 400,
            'approval' => 'Yes',
        ]);
    }
}

