<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->text('order_items');
            $table->integer('ordered_items');
            $table->string('customer_name');
            $table->string('customer_surname');
            $table->string('customer_address');
            $table->string('customer_city');
            $table->string('customer_email');
            $table->string('customer_phone');
            $table->date('delivery_date');
            $table->string('order_gateway');
            $table->string('order_gatewayRef');
            $table->double('usd_total');
            $table->double('zar_total');
            $table->double('zwl_total');
            $table->enum('order_status', ['pending', 'confirmed', 'packed', 'in-transit', 'delivered'])->default('pending');
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
        Schema::dropIfExists('orders');
    }
}
