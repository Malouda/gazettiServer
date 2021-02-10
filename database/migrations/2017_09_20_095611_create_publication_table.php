<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePublicationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publication', function (Blueprint $table) {
            $table->increments('id');
            $table->string('publication_name');
            $table->integer('publisher_id');
            $table->integer('type_id');
            $table->integer('language_id');
            $table->integer('perspective_id');
            $table->integer('daily');
            $table->integer('weekly');
            $table->text('description');
            $table->integer('maximum_headlines');
            $table->integer('minimum_headlines');
            $table->string('logo_url');
            $table->string('publication_email');
            $table->integer('publication_delete')->nullable()->default(0);
            $table->time('release_date')->nullable();
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
        Schema::dropIfExists('publication');
    }
}
