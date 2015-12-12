<?php

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
            $table->string('title', 20);
            $table->string('first_name', 150);
            $table->string('last_name', 150);
            $table->string('gender', 10);
            $table->string('user_name', 50);
	    $table->string('company', 255);
            $table->string('email')->unique();
            $table->string('password', 60);
            $table->string('address1', 255);
            $table->string('address2', 255);
            $table->string('city', 255);
            $table->string('state', 255);
            $table->string('country', 255);
            $table->string('postal', 25);
            $table->string('telephone', 50);
            $table->string('remark');
	    $table->string('timezone');
            $table->string('last_ip', 60);
            $table->boolean('is_active')->default(1);
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
        Schema::drop('users');
    }
}
