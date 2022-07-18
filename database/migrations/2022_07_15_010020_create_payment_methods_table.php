<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('pm_id');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('card_number');
            $table->string('brand')->nullable();
            $table->string('exp_month');
            $table->string('exp_year');
            $table->string('type')->default('card');
            $table->tinyInteger('default_method')->default(0);
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
        Schema::dropIfExists('payment_methods');
    }
}
