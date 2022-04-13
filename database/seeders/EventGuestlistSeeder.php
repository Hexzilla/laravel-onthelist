<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use App\Models\EventGuestlist;

class EventGuestlistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        EventGuestlist::truncate();
        Schema::enableForeignKeyConstraints();

        EventGuestlist::create([
            'event_id' => 1,
            'type' => 'Standard',
            'qty' => 50,
            'price' => 20,
            'approval' => 'Yes',
        ]);

        EventGuestlist::create([
            'event_id' => 1,
            'type' => 'EarlyBird',
            'qty' => 50,
            'price' => 15,
            'approval' => 'Yes',
        ]);

        EventGuestlist::create([
            'event_id' => 1,
            'type' => 'VIP',
            'qty' => 50,
            'price' => 25,
            'approval' => 'Yes',
        ]);

        EventGuestlist::create([
            'event_id' => 2,
            'type' => 'Standard',
            'qty' => 50,
            'price' => 40,
            'approval' => 'Yes',
        ]);

        EventGuestlist::create([
            'event_id' => 2,
            'type' => 'EarlyBird',
            'qty' => 50,
            'price' => 30,
            'approval' => 'Yes',
        ]);

        EventGuestlist::create([
            'event_id' => 2,
            'type' => 'VIP',
            'qty' => 50,
            'price' => 50,
            'approval' => 'Yes',
        ]);

        EventGuestlist::create([
            'event_id' => 3,
            'type' => 'Standard',
            'qty' => 50,
            'price' => 30,
            'approval' => 'Yes',
        ]);

        EventGuestlist::create([
            'event_id' => 3,
            'type' => 'EarlyBird',
            'qty' => 50,
            'price' => 25,
            'approval' => 'Yes',
        ]);

        EventGuestlist::create([
            'event_id' => 3,
            'type' => 'VIP',
            'qty' => 50,
            'price' => 40,
            'approval' => 'Yes',
        ]);
    }
}

