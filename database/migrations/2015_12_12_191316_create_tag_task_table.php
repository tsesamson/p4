<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagTaskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tag_task', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			
			$table->integer('tag_id')->unsigned();
			$table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
			
			$table->integer('task_id')->unsigned();
			$table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade');
			
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //$table->dropForeign('tag_task_tag_id_foreign');
		//$table->dropForeign('tag_task_task_id_foreign');
		
        Schema::drop('tag_task');
    }
}
