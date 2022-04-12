<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVenuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('venues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('type');
            $table->text('description')->nullable();
            $table->string('header_image_path');
            $table->string('address');
            $table->string('city');
            $table->string('postcode');
            $table->string('phone');
            $table->string('facilities')->nullable();
            $table->string('music_policy')->nullable();
            $table->string('dress_code')->nullable();
            $table->string('perks')->nullable();
            $table->enum('feature', ["yes", "no"])->default("no");
            $table->enum('status', ["Approved", "Pending", "Rejected"])->default("Pending");
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
        Schema::dropIfExists('venues');
    }
}
