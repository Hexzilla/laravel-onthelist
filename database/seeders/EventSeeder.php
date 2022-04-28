<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use App\Models\Event;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        Event::truncate();
        Schema::enableForeignKeyConstraints();

        Event::create([
            'user_id' => 1,
            'venue_id' => 1,
            'name' => 'Party Nonstop',
            'header_image_path' => 'images/event.jpg',
            'type' => 'Private',
            'start' => '2022-04-07',
            'end' => '2022-05-07',
            'status' => 'Approved',
            'is_weekly_event' => true,
        ]);

        Event::create([
            'user_id' => 1,
            'venue_id' => 1,
            'name' => 'Boogle Woogie',
            'header_image_path' => 'images/event.jpg',
            'type' => 'Private',
            'start' => '2022-04-07',
            'end' => '2022-05-07',
            'status' => 'Approved',
            'is_weekly_event' => true,
        ]);

        Event::create([
            'user_id' => 2,
            'venue_id' => 1,
            'name' => 'Drink TuesDay',
            'header_image_path' => 'images/event.jpg',
            'type' => 'Private',
            'start' => '2022-04-07',
            'end' => '2022-05-07',
            'is_weekly_event' => true,
        ]);
    }
}
