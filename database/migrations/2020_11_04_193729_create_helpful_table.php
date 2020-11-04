<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHelpfulTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('helpful', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('rating_id');
            $table->bigInteger('gift_id');
            $table->bigInteger('user_id');
            $table->enum('status', ['not-seen', 'seen'])->default('not-seen');
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
        Schema::dropIfExists('helpful');
    }
}
