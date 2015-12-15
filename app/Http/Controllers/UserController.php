<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
	
	public function getProfile()
	{
		return view('user.profile');
	}
	
	public function postProfile(Request $request)
	{
			$this->validate($request, [
			'txtEmail' => 'required|email',
			'txtFirstName' => 'required|max:50',
			'txtLastName' => 'required|max:50',
			'txtCompany' => 'max:50',
			'txtAddress1' => 'max:255',
			'txtAddress2' => 'max:255',
			'txtCity' => 'max:150',
			'txtState' => 'max:150',
			'txtCountry' => 'max:150',
			'txtPostal' => 'max:25',
		]);
		
		$user = \Auth::user();
		
		// Save all the input field into user object
		try {
			$user->email = $request->input('txtEmail');
			$user->first_name = $request->input('txtFirstName');
			$user->last_name = $request->input('txtLastName');
			$user->company = $request->input('txtCompany');
			$user->address1 = $request->input('txtAddress1');
			$user->address2 = $request->input('txtAddress2');
			$user->city = $request->input('txtCity');
			$user->state = $request->input('txtState');
			$user->country = $request->input('txtCountry');
			$user->postal = $request->input('txtPostal');
			$user->save();
			
			// Set the flash message for completing the user profile update
			\Session::flash('alert-success', "User Profile updated successfully.");
		} catch(Exception $e) {
			
			\Session::flash('alert-danger', $e->getMessage());
		}
		
		
		return view('user.profile');

	}
	
	public function getPassword()
	{
		return view('user.password');
	}
	
	public function postPassword(Request $request)
	{
		$this->validate($request, [
			'old_password' => 'required|min:3',
			'password' => 'required|min:3|confirmed',
			'password_confirmation' => 'required|min:3',
		]);
		
		$user = \Auth::user();
		
		if(\Auth::validate(['email' => $user->email, 'password' => $request->input('old_password')])){
			if(isset($_POST['password']))
			{
				$user->password = \Hash::make($request->input('password'));
				$user->save();			
			}
		}

		
		// Set the flash message for completing the password change
		\Session::flash('alert-success', "Password changed successfully.");
		
		return view('user.password');
	}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
