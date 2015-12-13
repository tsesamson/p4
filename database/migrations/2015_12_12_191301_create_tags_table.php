<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			
			$table->integer('user_id')->unsigned();
			//$table->foreign('user_id')->references('id')->on('users');
			
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
		//$table->dropForeign('tags_user_id_foreign');
		
        Schema::drop('tags');
    }
}
