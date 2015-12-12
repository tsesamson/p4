<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		# This is where we define the Schema for the timers table
		Schema::create('timers', function(Blueprint $table) {

			# Increments method will make a Primary, Aut-Incrementing field.
			$table->increments('id');

			# This generates two columns: 'created_at' and 'updated_at'
			$table->timestamps();

			# Create fields to keep track of which user created or updated the timer
			$table->integer('task_id')->unsigned();
			$table->foreign('task_id')->references('id')->on('tasks');
			
			$table->integer('created_by')->unsigned();
			$table->foreign('created_by')->references('id')->on('users');

			$table->integer('updated_by')->unsigned();
			$table->foreign('updated_by')->references('id')->on('users');

			# Rest of the timer fields
			$table->integer('duration')->unsigned();
			$table->string('comment');

			# For soft delete
			$table->softDeletes();

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		$table->dropForeign('timers_task_id_foreign');
    	$table->dropForeign('timers_created_by_foreign');
    	$table->dropForeign('timers_updated_by_foreign');

        Schema::drop('timers');
    }
}
