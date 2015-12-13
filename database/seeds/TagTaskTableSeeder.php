<?php

use Illuminate\Database\Seeder;

class TagTaskTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('tag_task')->insert([
			'created_at' => Carbon\Carbon::now()->toDateTimeString(),
			'updated_at' => Carbon\Carbon::now()->toDateTimeString(),
			'tag_id' => 1,
			'task_id' => 1,
		]);

		DB::table('tag_task')->insert([
			'created_at' => Carbon\Carbon::now()->toDateTimeString(),
			'updated_at' => Carbon\Carbon::now()->toDateTimeString(),
			'tag_id' => 2,
			'task_id' => 1,
		]);  
		
		DB::table('tag_task')->insert([
			'created_at' => Carbon\Carbon::now()->toDateTimeString(),
			'updated_at' => Carbon\Carbon::now()->toDateTimeString(),
			'tag_id' => 3,
			'task_id' => 2,
		]);  
		
		DB::table('tag_task')->insert([
			'created_at' => Carbon\Carbon::now()->toDateTimeString(),
			'updated_at' => Carbon\Carbon::now()->toDateTimeString(),
			'tag_id' => 4,
			'task_id' => 2,
		]);  
		
		DB::table('tag_task')->insert([
			'created_at' => Carbon\Carbon::now()->toDateTimeString(),
			'updated_at' => Carbon\Carbon::now()->toDateTimeString(),
			'tag_id' => 5,
			'task_id' => 3,
		]);  
		
		DB::table('tag_task')->insert([
			'created_at' => Carbon\Carbon::now()->toDateTimeString(),
			'updated_at' => Carbon\Carbon::now()->toDateTimeString(),
			'tag_id' => 6,
			'task_id' => 3,
		]);  
		
		DB::table('tag_task')->insert([
			'created_at' => Carbon\Carbon::now()->toDateTimeString(),
			'updated_at' => Carbon\Carbon::now()->toDateTimeString(),
			'tag_id' => 7,
			'task_id' => 4,
		]);  
		
		DB::table('tag_task')->insert([
			'created_at' => Carbon\Carbon::now()->toDateTimeString(),
			'updated_at' => Carbon\Carbon::now()->toDateTimeString(),
			'tag_id' => 8,
			'task_id' => 4,
		]);  
		
		DB::table('tag_task')->insert([
			'created_at' => Carbon\Carbon::now()->toDateTimeString(),
			'updated_at' => Carbon\Carbon::now()->toDateTimeString(),
			'tag_id' => 9,
			'task_id' => 4,
		]);  
		
		DB::table('tag_task')->insert([
			'created_at' => Carbon\Carbon::now()->toDateTimeString(),
			'updated_at' => Carbon\Carbon::now()->toDateTimeString(),
			'tag_id' => 10,
			'task_id' => 5,
		]);  
		
		DB::table('tag_task')->insert([
			'created_at' => Carbon\Carbon::now()->toDateTimeString(),
			'updated_at' => Carbon\Carbon::now()->toDateTimeString(),
			'tag_id' => 11,
			'task_id' => 5,
		]);  
		
		DB::table('tag_task')->insert([
			'created_at' => Carbon\Carbon::now()->toDateTimeString(),
			'updated_at' => Carbon\Carbon::now()->toDateTimeString(),
			'tag_id' => 12,
			'task_id' => 5,
		]);  
		
    }
}
