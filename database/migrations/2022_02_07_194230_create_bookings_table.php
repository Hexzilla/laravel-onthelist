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
            $table->foreignId("event_id")->constrained()->onDelete('cascade');
            $table->enum("booking_type", ["Table", "Ticket", "Guestlist"]);
            $table->enum("type", ["EarlyBird", "VIP", "Standard"]);
            $table->integer('qty');
            $table->double('price', 10, 2)->default(0);
            $table->enum("status", ["Approved", "Pending", "Rejected"])->default('Pending');
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
