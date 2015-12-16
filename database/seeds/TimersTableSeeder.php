<?php

use Illuminate\Database\Seeder;

class TimersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('timers')->insert([
			'created_at' => Carbon\Carbon::now()->toDateTimeString(),
			'updated_at' => Carbon\Carbon::now()->toDateTimeString(),
			'start' => Carbon\Carbon::now()->toDateTimeString(),
			'duration' => 90,
			'project_id' => 1,
			'task_id' => 1,
			'created_by' => 1,
			'updated_by' => 1,
			'comment' => '',
		]);   
		
		DB::table('timers')->insert([
			'created_at' => Carbon\Carbon::now()->toDateTimeString(),
			'updated_at' => Carbon\Carbon::now()->toDateTimeString(),
			'start' => Carbon\Carbon::now()->toDateTimeString(),
			'duration' => 225,
			'project_id' => 1,
			'task_id' => 1,
			'created_by' => 1,
			'updated_by' => 1,
		]);   
		
		DB::table('timers')->insert([
			'created_at' => Carbon\Carbon::now()->toDateTimeString(),
			'updated_at' => Carbon\Carbon::now()->toDateTimeString(),
			'start' => Carbon\Carbon::now()->toDateTimeString(),
			'duration' => 1234,
			'project_id' => 1,
			'task_id' => 1,
			'created_by' => 1,
			'updated_by' => 1,
			'comment' => 'Took some time but I figured it out.',
		]);   
    }
}

