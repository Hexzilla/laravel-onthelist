<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->constrained()->onDelete('cascade');
            $table->foreignId("client_id")->constrained()->onDelete('cascade');
            $table->string('client_name');
            $table->foreignId("event_id")->constrained()->onDelete('cascade');
            $table->string("event_name");
            $table->string("venue");
            $table->enum("event_type", ["Private", "Public"]);
            $table->enum("type", ["Table Booking", "Ticket", "Guestlist"]);
            $table->double("price", 10, 2)->default(0);
            $table->enum("status", ["Approved", "Pending"])->default('Pending');
            $table->date("date");
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
        Schema::dropIfExists('bookings');
    }
}
