<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		# This is where we define the Schema for the tasks table
		Schema::create('tasks', function(Blueprint $table) {

			# Increments method will make a Primary, Aut-Incrementing field.
			$table->increments('id');

			# This generates two columns: 'created_at' and 'updated_at'
			$table->timestamps();

			$table->integer('project_id')->unsigned();
			$table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
			
			$table->integer('user_id')->unsigned();
			//$table->foreign('user_id')->references('id')->on('users');

			$table->integer('assigned_to')->unsigned();
			//$table->foreign('assigned_to')->references('id')->on('users');
			
			$table->integer('created_by')->unsigned();
			//$table->foreign('created_by')->references('id')->on('users');

			$table->integer('updated_by')->unsigned();
			//$table->foreign('updated_by')->references('id')->on('users');

			# Rest of the task fields
			//$table->integer('status_id')->unsigned()->default(0);
			$table->enum('status', ['completed', 'initialized', 'pending', 'approved', 'rejected'])->default('initialized');
			//$table->integer('priority_id')->unsigned()->default(0);
			$table->enum('priority', ['high', 'medium', 'low'])->default('low');
			$table->string('name');
			$table->text('description');
			$table->integer('duration')->unsigned()->default(0);
			$table->datetime('start_date');
			$table->datetime('end_date');
			$table->datetime('due_date');
			$table->string('comment');
			$table->boolean('is_active')->default(1);

			# For soft delete
			$table->softDeletes();

		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		//$table->dropForeign('tasks_project_id_foreign');
    	//$table->dropForeign('tasks_user_id_foreign');
		//$table->dropForeign('tasks_assigned_to_foreign');
    	//$table->dropForeign('tasks_created_by_foreign');
    	//$table->dropForeign('tasks_updated_by_foreign');

        Schema::drop('tasks');
    }
}
