<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_users', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			
			$table->integer('project_id')->unsigned();
			$table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');;
			
			$table->integer('user_id')->unsigned();
			//$table->foreign('user_id')->references('id')->on('users');
			
			$table->boolean('is_admin')->default(0); // Determines if this user has admin rights to the project
			$table->float('rate'); // Set the hourly rate for this project user
			
			$table->string('name');
			
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('project_users');
    }
}
