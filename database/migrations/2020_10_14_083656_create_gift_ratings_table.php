<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGiftRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gift_ratings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('gift_id');
            $table->bigInteger('user_id');
            $table->decimal('customer_rating');
            $table->text('customer_review');
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
        Schema::dropIfExists('gift_ratings');
    }
}
