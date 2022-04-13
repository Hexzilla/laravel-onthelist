<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('venue_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->enum('type', ["Public", "Private"]);
            $table->text('description')->nullable();
            $table->string('header_image_path');
            $table->datetime('start');
            $table->datetime('end');
            $table->boolean('is_weekly_event');
            $table->enum('feature', ["yes", "no"])->default("no");
            $table->enum('status', ["Pending", "Approved", "Rejected", "Progress", "Completed"])->default("Pending");
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
        Schema::dropIfExists('events');
    }
}
