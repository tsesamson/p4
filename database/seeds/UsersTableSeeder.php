<?php

use Illuminate\Database\Seeder;
use \App\User as User;
//use FakerGenerator;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$faker = FakerGenerator::create(); //Create the Faker object for user generation
		
		//My test account
		$user = User::firstOrCreate(['email' => 'tse.samson@gmail.com']);
		$user->password = \Hash::make('100216910');
		$user->title = $faker->title;
		$user->first_name = 'Samson';
		$user->last_name = 'Tse';
		$user->gender = '';
		$user->user_name = 'tse.samson';
		$user->company = $faker->company;
		$user->last_ip = $faker->ipv4;
		$user->is_active = 1;
		$user->address1 = $faker->streetAddress;
		$user->address2 = $faker->secondaryAddress;
		$user->city = $faker->city;
		$user->state = $faker->state;
		$user->country = $faker->country;
		$user->postal = $faker->postcode;
		$user->telephone = $faker->phoneNumber;
		$user->remark = '';
		$user->timezone = $faker->timezone;		
		$user->save();
		
		// Default users required by P4
		$faker = FakerGenerator::create();
		$user = User::firstOrCreate(['email' => 'jill@harvard.edu']);
		$user->password = \Hash::make('helloworld');
		$user->title = $faker->title;
		$user->first_name = 'Jill';
		$user->last_name = 'Harvard';
		$user->gender = '';
		$user->user_name = 'jill.harvard';
		$user->company = $faker->company;
		$user->last_ip = $faker->ipv4;
		$user->is_active = 1;
		$user->address1 = $faker->streetAddress;
		$user->address2 = $faker->secondaryAddress;
		$user->city = $faker->city;
		$user->state = $faker->state;
		$user->country = $faker->country;
		$user->postal = $faker->postcode;
		$user->telephone = $faker->phoneNumber;
		$user->remark = '';
		$user->timezone = $faker->timezone;
		$user->save();

		$faker = FakerGenerator::create();
		$user = User::firstOrCreate(['email' => 'jamal@harvard.edu']);
		$user->password = \Hash::make('helloworld');
		$user->title = $faker->title;
		$user->first_name = 'Jamal';
		$user->last_name = 'Harvard';
		$user->gender = '';
		$user->user_name = 'jamal.harvard';
		$user->company = $faker->company;
		$user->last_ip = $faker->ipv4;
		$user->is_active = 1;
		$user->address1 = $faker->streetAddress;
		$user->address2 = $faker->secondaryAddress;
		$user->city = $faker->city;
		$user->state = $faker->state;
		$user->country = $faker->country;
		$user->postal = $faker->postcode;
		$user->telephone = $faker->phoneNumber;
		$user->remark = '';
		$user->timezone = $faker->timezone;
		$user->save();
		
		
		for ($i = 0; $i < 10; $i++) {
			
			// Create fake users
			$faker = FakerGenerator::create(); 

			$user = User::firstOrCreate(['email' => $faker->email]);

			$user->title = $faker->title;
			$user->first_name = $faker->firstName;
			$user->last_name = $faker->lastName;
			$user->gender = '';
			$user->user_name = $faker->userName;
			$user->company = $faker->company;
			$user->password = \Hash::make('helloworld');
			$user->last_ip = $faker->ipv4;
			$user->is_active = 1;
			$user->address1 = $faker->streetAddress;
			$user->address2 = $faker->secondaryAddress;
			$user->city = $faker->city;
			$user->state = $faker->state;
			$user->country = $faker->country;
			$user->postal = $faker->postcode;
			$user->telephone = $faker->phoneNumber;
			$user->remark = '';
			$user->timezone = $faker->timezone;

			$user->save();
		}
    }
}
