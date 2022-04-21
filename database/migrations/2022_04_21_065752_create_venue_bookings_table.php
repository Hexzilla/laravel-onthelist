<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVenueBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('venue_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->constrained()->onDelete('cascade');
            $table->foreignId("venue_id")->constrained()->onDelete('cascade');
            $table->enum("booking_type", ["Offer", "Table"]);
            $table->string("type");
            $table->double("price", 10, 2)->default(0);
            $table->enum("status", ["Approved", "Pending", "Rejected"])->default('Pending');
            $table->date("date");
            $table->time("time")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('venue_bookings');
    }
}
