<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use App\Models\EventTicket;

class EventTicketsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        EventTicket::truncate();
        Schema::enableForeignKeyConstraints();

        EventTicket::create([
            'event_id' => 1,
            'type' => 'Standard',
            'qty' => 50,
            'price' => 20,
            'approval' => 'Yes',
        ]);

        EventTicket::create([
            'event_id' => 1,
            'type' => 'Low',
            'qty' => 50,
            'price' => 15,
            'approval' => 'Yes',
        ]);

        EventTicket::create([
            'event_id' => 1,
            'type' => 'High',
            'qty' => 50,
            'price' => 25,
            'approval' => 'Yes',
        ]);

        EventTicket::create([
            'event_id' => 2,
            'type' => 'Standard',
            'qty' => 50,
            'price' => 40,
            'approval' => 'Yes',
        ]);

        EventTicket::create([
            'event_id' => 2,
            'type' => 'Low',
            'qty' => 50,
            'price' => 30,
            'approval' => 'Yes',
        ]);

        EventTicket::create([
            'event_id' => 2,
            'type' => 'High',
            'qty' => 50,
            'price' => 50,
            'approval' => 'Yes',
        ]);

        EventTicket::create([
            'event_id' => 3,
            'type' => 'Standard',
            'qty' => 50,
            'price' => 30,
            'approval' => 'Yes',
        ]);

        EventTicket::create([
            'event_id' => 3,
            'type' => 'Low',
            'qty' => 50,
            'price' => 25,
            'approval' => 'Yes',
        ]);

        EventTicket::create([
            'event_id' => 3,
            'type' => 'High',
            'qty' => 50,
            'price' => 40,
            'approval' => 'Yes',
        ]);
    }
}
