<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Routes for Authentication Controller

Route::get('/login', 'Auth\AuthController@getLogin');  //Show login form
Route::post('/login', 'Auth\AuthController@postLogin');  //Process login form
Route::get('/logout', 'Auth\AuthController@getLogout');  //Process logout
Route::get('/register', 'Auth\AuthController@getRegister');  //Show registration form
Route::post('/register', 'Auth\AuthController@postRegister');  //Process registration form

//Debug Route
Route::get('/debug', function() {
	echo '<pre>';

	echo '<h1>Environment</h1>';
	echo App::environment().'</h1>';

	echo '<h1>Debugging?</h1>';
	if(config('app.debug')) echo "Yes"; else echo "No";

	echo '<h1>Database Config</h1>';

	//Output Mysql credentials
	echo '<h1>Test Database Connection</h1>';
	try {
		$result= DB::select('SHOW DATABASES;');
		echo '<strong style="background-color:green; padding:5px;">Connection confirmed</strong>';
		echo"<br/><br/>Your Databases:<br/><br/>";
		print_r($result);
	}
	catch(Exception $e) {
		echo '<strong style="background-color:crimson; padding:5px;">Caught exception: ', $e->getMessage(), "</strong>\n";
	}

	echo '</pre>';
});

//Dev only route to flush db for a fresh restart

if(App::environment('local')) {
  Route::get('/refresh', function() {
	DB::statement('DROP database tdb');
	DB::statement('CREATE database tdb');

	return 'Dropped tdb database; Create tdb database;';
  });
};
