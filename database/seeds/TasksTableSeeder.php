<?php

use Illuminate\Database\Seeder;

class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('tasks')->insert([
			'created_at' => Carbon\Carbon::now()->toDateTimeString(),
			'updated_at' => Carbon\Carbon::now()->toDateTimeString(),
			'description' => 'Create all the #migration files for the application #jamal@harvard.edu',
			'project_id' => 1,
			'user_id' => 1,
			'assigned_to' => 2,
			'created_by' => 1,
			'updated_by' => 1,
			'due_date' => Carbon\Carbon::now()->toDateTimeString(),
		]);   
		
		DB::table('tasks')->insert([
			'created_at' => Carbon\Carbon::now()->toDateTimeString(),
			'updated_at' => Carbon\Carbon::now()->toDateTimeString(),
			'description' => 'Create #seeder for loading #data into db tables.',
			'project_id' => 1,
			'user_id' => 1,
			'assigned_to' => 2,
			'created_by' => 1,
			'updated_by' => 1,
			'due_date' => Carbon\Carbon::now()->toDateTimeString(),
		]);   
		
		DB::table('tasks')->insert([
			'created_at' => Carbon\Carbon::now()->toDateTimeString(),
			'updated_at' => Carbon\Carbon::now()->toDateTimeString(),
			'description' => 'Complete coding all the #model in the #app',
			'project_id' => 1,
			'user_id' => 1,
			'created_by' => 1,
			'updated_by' => 1,
			'due_date' => Carbon\Carbon::now()->toDateTimeString(),
		]);   
		
		DB::table('tasks')->insert([
			'created_at' => Carbon\Carbon::now()->toDateTimeString(),
			'updated_at' => Carbon\Carbon::now()->toDateTimeString(),
			'description' => 'Get the #requirements from stakeholders #jill@harvard.edu',
			'project_id' => 2,
			'user_id' => 2,
			'assigned_to' => 1,
			'created_by' => 2,
			'updated_by' => 2,
			'due_date' => Carbon\Carbon::now()->toDateTimeString(),
		]);

		DB::table('tasks')->insert([
			'created_at' => Carbon\Carbon::now()->toDateTimeString(),
			'updated_at' => Carbon\Carbon::now()->toDateTimeString(),
			'description' => 'Create #ganttchart with all the #resources and #deliverables.',
			'project_id' => 2,
			'user_id' => 2,
			'created_by' => 2,
			'updated_by' => 2,
			'due_date' => Carbon\Carbon::now()->toDateTimeString(),
		]);   		
		
		
    }
}
