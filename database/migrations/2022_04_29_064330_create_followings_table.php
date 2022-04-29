<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFollowingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('followings', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->constrained('users', 'id')->onDelete('cascade');
            $table->foreignId("following_user_id")->constrained('users', 'id')->onDelete('cascade');
            $table->timestamps();
            $table->unique(["user_id", "following_user_id"], 'user_following_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('followings');
    }
}
