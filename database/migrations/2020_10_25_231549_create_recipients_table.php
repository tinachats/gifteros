<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecipientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipients', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->bigInteger('friend_id');
            $table->string('recipients_name');
            $table->string('recipients_surname');
            $table->string('recipients_cell');
            $table->string('recipients_email');
            $table->string('recipients_address');
            $table->string('recipients_city');
            $table->enum('status', ['recipient', 'friend'])->default('recipient');
            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recipients');
    }
}
