<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderedGiftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ordered_gifts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('order_id');
            $table->string('track_id');
            $table->bigInteger('gift_id');
            $table->integer('quantity');
            $table->decimal('usd_total');
            $table->decimal('zar_total');
            $table->decimal('zwl_total');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ordered_gifts');
    }
}
