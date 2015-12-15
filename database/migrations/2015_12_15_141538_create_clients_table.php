<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			
			$table->integer('user_id')->unsigned();
			//$table->foreign('user_id')->references('id')->on('users');
			
			$table->boolean('is_admin')->default(0); // Determines if this user has admin rights to the project
			$table->float('rate'); // Set the hourly rate for this client
			$table->string('currency'); // Set the client's currency which will be reflected on project/task rate
			
			$table->string('name');  // Name of the client
			$table->text('note');  // Notes for the client
			
		});
    }
	
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('clients');
    }
}
