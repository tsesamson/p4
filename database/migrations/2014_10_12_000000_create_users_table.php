<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
			$table->boolean('is_openid_enabled'); //Is Google signin enabled?
            $table->string('title', 20);
            $table->string('first_name', 150);
            $table->string('last_name', 150);
            $table->string('gender', 10);
            $table->string('user_name', 50); // Future use if we decide to go with username as well as email
			$table->string('image_url'); //User's profile image
			$table->string('company', 255);
            $table->string('email')->unique();
            $table->string('password', 60);
            $table->string('address1', 255);
            $table->string('address2', 255); 
            $table->string('city', 255);
            $table->string('state', 255);
            $table->string('country', 255);
            $table->string('postal', 25);
            $table->string('telephone', 50);
            $table->string('remark');  // For site admin use
			$table->string('timezone'); // User can specify their timezone in profile (https://en.wikipedia.org/wiki/List_of_tz_database_time_zones)
            $table->string('last_ip', 60); // The last ip addressed used to signon
            $table->boolean('is_active')->default(1);
			$table->string('api_token'); // Future use if we release API
			$table->string('date_format')->default('m/d/y'); // Allow user to set their prefer date format
			$table->string('language'); //Allow user to set language preference
			$table->boolean('send_newsletters')->default(1); // User can disable receiving email from application
			$table->boolean('send_report')->default(1); // User option to receive weekly email report
			$table->boolean('send_idle_timer')->default(1); // Email user about idle timer (> 8 hrs) for any tasks
            $table->rememberToken();
            $table->timestamps();
        });
    }
	
api_token: (string)
default_wid: default workspace id (integer)
email: (string)
jquery_timeofday_format: (string)
jquery_date_format:(string)
timeofday_format: (string)
date_format: (string)
store_start_and_stop_time: whether start and stop time are saved on time entry (boolean)
beginning_of_week: (integer 0-6, Sunday=0)
language: user's language (string)
image_url: url with the user's profile picture(string)
sidebar_piechart: should a piechart be shown on the sidebar (boolean)
at: timestamp of last changes
new_blog_post: an object with toggl blog post title and link
send_product_emails: (boolean) Toggl can send newsletters over e-mail to the user
send_weekly_report: (boolean) if user receives weekly report
send_timer_notifications: (boolean) email user about long-running (more than 8 hours) tasks
openid_enabled: (boolean) google signin enabled

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
