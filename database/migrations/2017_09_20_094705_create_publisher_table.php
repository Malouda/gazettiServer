<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePublisherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publisher', function (Blueprint $table) {
            $table->increments('id');
            $table->string('publisher_name');
            $table->integer('location_id');
            $table->string('email');
            $table->string('publisher_phone');
            $table->integer('maximum_employees');
            $table->timestamp('account_expiry');
            $table->integer('status');
            $table->string('logo_url')->nullable();
            $table->integer('publisher_delete')->nullable();
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
        Schema::dropIfExists('publisher');
    }
}
