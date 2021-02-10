<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHeadlinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('headlines', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('publication_id');
            $table->integer('perspective_id');
            $table->integer('section_id');
            $table->string('heading');
            $table->string('subheading')->nullable();
            $table->text('briefnote');
            $table->string('image_url')->nullable();
            $table->date('release_date')->nullable();
            $table->time('release_time')->nullable();
            $table->date('next_release')->nullable();
            $table->time('next_releasetime')->nullable();     
            $table->integer('headline_blocked')->nullable()->default(0);
            $table->integer('headline_removed')->nullable()->default(0);
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
        Schema::dropIfExists('headlines');
    }
}
