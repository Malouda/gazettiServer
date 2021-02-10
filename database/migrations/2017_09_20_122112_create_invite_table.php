<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInviteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invite', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('inviter_id');
            $table->integer('invited_id');
            $table->string('invited_phone');
            $table->string('token');
            $table->integer('publication_id');
            $table->integer('token_expired')->default(0);
            $table->integer('group_id');
            $table->integer('publisher_id')->nullable();
            $table->integer('used')->nullable()->default(0);
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
        Schema::dropIfExists('invite');
    }
}
