<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoverPageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coverpage', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('publication_id');
            $table->integer('perspective_id');
            $table->string('cover_page_url');
            $table->date('release_date')->nullable();
            $table->time('release_time')->nullable();
            $table->date('next_release')->nullable();
            $table->time('next_releasetime')->nullable();            
            $table->integer('cover_page_removed')->nullable()->default(0);
            $table->integer('cover_page_blocked')->nullable()->default(0);
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
        Schema::dropIfExists('coverpage');
    }
}
