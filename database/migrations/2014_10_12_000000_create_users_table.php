<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fname');
            $table->string('lname');
            $table->string('username');
            $table->string('password');
            $table->integer('user_group_id');
            $table->integer('publication_id')->nullable();
            $table->integer('publisher_id')->nullable();
            $table->integer('location_id');
            $table->string('phone')->unique();
            $table->string('email')->unique();
            $table->integer('age');
            $table->string('gender_id');
            $table->string('profile_picture_url')->nullable();
            $table->string('forgot_passwordCode')->nullable();
            $table->integer('forgotPasswordCodeUsed')->default(0);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
