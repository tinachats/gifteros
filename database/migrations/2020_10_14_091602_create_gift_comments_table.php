<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGiftCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gift_comments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('rating_id');
            $table->bigInteger('user_id');
            $table->text('comment');
            $table->enum('status', ['not-seen', 'seen']);
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
        Schema::dropIfExists('gift_comments');
    }
}
