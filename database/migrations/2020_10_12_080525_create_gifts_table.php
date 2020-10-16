<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGiftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gifts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('category_id');
            $table->bigInteger('sub_category_id');
            $table->string('gift_name');
            $table->string('gift_image');
            $table->decimal('usd_price');
            $table->decimal('zar_price');
            $table->decimal('zwl_price');
            $table->decimal('sale_usd_price');
            $table->decimal('sale_zar_price');
            $table->decimal('sale_zwl_price');
            $table->dateTime('start_on');
            $table->dateTime('ends_on');
            $table->text('description');
            $table->integer('units');
            $table->enum('label', ['new','sale','eco-friendly','eco-design','hot-offer','customizable','organic']);
            $table->decimal('custom_usd_price');
            $table->decimal('custom_zar_price');
            $table->decimal('custom_zwl_price');
            $table->string('added_by');
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
        Schema::dropIfExists('gifts');
    }
}
