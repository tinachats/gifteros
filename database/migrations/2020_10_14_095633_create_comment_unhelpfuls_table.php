<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentUnhelpfulsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comment_unhelpful', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('rating_id');
            $table->bigInteger('gift_id');
            $table->bigInteger('user_id');
            $table->enum('status', ['not-seen', 'seen'])->defaut('not-seen');
            $table->enum('notification_bg', ['#f8f9fa;','#fff'])->default('#f8f9fa;');
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
        Schema::dropIfExists('comment_unhelpfuls');
    }
}
