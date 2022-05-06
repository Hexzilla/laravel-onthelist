<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use App\Models\Plan;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        Plan::truncate();
        Schema::enableForeignKeyConstraints();

        Plan::create([
            'name' => 'Basic',
            'price' => 29,
        ]);

        Plan::create([
            'name' => 'Standard',
            'price' => 59,
        ]);

        Plan::create([
            'name' => 'Premium',
            'price' => 99,
        ]);
    }
}
