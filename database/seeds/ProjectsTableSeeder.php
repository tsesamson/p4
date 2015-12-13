<?php

use Illuminate\Database\Seeder;
//use \App\Project as Project;

class ProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('projects')->insert([
			'created_at' => Carbon\Carbon::now()->toDateTimeString(),
			'updated_at' => Carbon\Carbon::now()->toDateTimeString(),
			'name' => 'Task Driver Application',
			'description' => 'Need to build an application to complete P4.',
			'user_id' => 1,
			'created_by' => 1,
			'updated_by' => 1,
			'due_date' => Carbon\Carbon::now()->toDateTimeString(),
		]);   
		
		DB::table('projects')->insert([
			'created_at' => Carbon\Carbon::now()->toDateTimeString(),
			'updated_at' => Carbon\Carbon::now()->toDateTimeString(),
			'name' => 'John Doe',
			'description' => 'Create a simple application for JD',
			'user_id' => 1,
			'created_by' => 1,
			'updated_by' => 1,
			'due_date' => Carbon\Carbon::now()->toDateTimeString(),
		]);   
		
		DB::table('projects')->insert([
			'created_at' => Carbon\Carbon::now()->toDateTimeString(),
			'updated_at' => Carbon\Carbon::now()->toDateTimeString(),
			'name' => 'Laravel Application',
			'description' => 'Need to build an application to complete P4.',
			'user_id' => 2,
			'created_by' => 2,
			'updated_by' => 2,
			'due_date' => Carbon\Carbon::now()->toDateTimeString(),
		]);   
		
		DB::table('projects')->insert([
			'created_at' => Carbon\Carbon::now()->toDateTimeString(),
			'updated_at' => Carbon\Carbon::now()->toDateTimeString(),
			'name' => 'Jane Doe',
			'description' => 'Create a simple application for JD',
			'user_id' => 2,
			'created_by' => 2,
			'updated_by' => 2,
			'due_date' => Carbon\Carbon::now()->toDateTimeString(),
		]);   		
		
    }
}
