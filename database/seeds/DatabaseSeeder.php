<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(UsersTableSeeder::class);
		$this->call(ProjectsTableSeeder::class);
		$this->call(TasksTableSeeder::class);
		$this->call(TimersTableSeeder::class);
		$this->call(TagsTableSeeder::class);
		$this->call(TagTaskTableSeeder::class);
		
        Model::reguard();
    }
}
