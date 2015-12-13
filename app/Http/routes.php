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
    //return view('welcome');
    return redirect('/login');
});

// Routes for Authentication Controller

Route::get('/login', 'Auth\AuthController@getLogin');  //Show login form
Route::post('/login', 'Auth\AuthController@postLogin');  //Process login form
Route::get('/logout', 'Auth\AuthController@getLogout');  //Process logout
Route::get('/register', 'Auth\AuthController@getRegister');  //Show registration form
Route::post('/register', 'Auth\AuthController@postRegister');  //Process registration form

// Routes for Tasks

Route::group(['middleware' => 'auth'], function() {

	Route::get('/home', 'TaskController@getIndex');  //Show Home page

    //Route::get('/tasks/create', 'TaskController@getCreate');
    //Route::post('/tasks/create', 'TaskController@postCreate');

	// Test POST AJAX route
	Route::post('/tasks/create', function () {
		// pass back some data, along with the original data, just to prove it was received
		$data   = array('value' => 'Output from ajax', 'input' => Request::input());
		// return a JSON response
		return  Response::json($data);
	});

    //Route::get('/tasks/edit/{id?}', 'TaskController@getEdit');
    //Route::post('/tasks/edit', 'TaskController@postEdit');

    //Route::get('/tasks', 'TaskController@getIndex');
    //Route::get('/tasks/show/{id?}', 'TaskController@getShow');

});

// Used to confirm that the authentication is working (can be removed after auth is tested)
Route::get('/confirm-login', function() {
	$user = Auth::user();

	if($user) {
		echo 'You are logged in ';
		dump($user->toArray());
	} else {
		echo 'You are not logged in';
	}
	return;
});

// Debug Route
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
