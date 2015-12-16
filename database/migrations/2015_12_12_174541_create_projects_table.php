<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		# This is where we define the Schema for the project table
		Schema::create('projects', function(Blueprint $table) {

			# Increments method will make a Primary, Aut-Incrementing field.
			$table->increments('id');

			# This generates two columns: 'created_at' and 'updated_at'
			$table->timestamps();

			# Create fields to keep track of which user owns, created or updated the project
			$table->integer('user_id')->unsigned();
			//$table->foreign('user_id')->references('id')->on('users');

			$table->integer('client_id')->unsigned();
			//$table->foreign('client_id')->references('id')->on('clients');
			
			$table->integer('template_id')->unsigned();  //  Future use: the project_id used on current project's creation as template
			
			$table->integer('created_by')->unsigned();
			//$table->foreign('created_by')->references('id')->on('users');

			$table->integer('updated_by')->unsigned();
			//$table->foreign('updated_by')->references('id')->on('users');

			# Rest of the project fields
			//$table->integer('status_id')->unsigned()->default(0);
			$table->enum('status', ['completed', 'started', 'pending', 'approved', 'rejected'])->default('started');
			$table->string('name');
			$table->text('description');
			$table->integer('duration')->unsigned()->default(0);  // Track the duration of the project
			$table->integer('duration_limit')->unsigned()->default(0);  // Set a duration limit for the project
			$table->datetime('start_date');
			$table->datetime('end_date');
			$table->datetime('due_date');
			$table->string('comment');
			$table->boolean('is_active')->default(1);
			$table->boolean('is_private')->default(1); // All projects are private by default unless specify by user
			$table->boolean('is_global')->default(0); // Projects are allowed to be global where anyone can create task for it
			$table->boolean('is_template')->default(0); // Future use: determine if this project can be use as a template for other projects
			$table->boolean('is_billable')->default(0); // Future use: define if the project is billable or not
			$table->float('rate'); // Future use: Allow user to set hourly rate of the project
			
			# For soft delete
			$table->softDeletes();

			# Add basic index to name
			$table->index('name');

		});
    }
	

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    	//$table->dropForeign('projects_user_id_foreign');
    	//$table->dropForeign('projects_created_by_foreign');
    	//$table->dropForeign('projects_updated_by_foreign');

        Schema::drop('projects');
    }
}
