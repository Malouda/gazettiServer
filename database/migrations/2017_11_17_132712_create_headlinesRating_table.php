<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHeadlinesRatingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('headlinesrating', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('headline_id');
            $table->integer('like');
            $table->integer('mixedThoughts');
            $table->integer('dontLike');
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
        Schema::dropIfExists('headlinesRating');
    }
}
