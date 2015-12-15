@extends('layouts.master')

@section('title')
	Task Driver - User Profile
@stop

@section('page-title')
	Task Driver
@stop

@section('content')


<!--Section for User profile -->

      <div class="container-fluid">
         <form method="post" action="/users/profile">
			<!-- pass through the CSRF (cross-site request forgery) token -->
			<input type="hidden" value="{{ csrf_token() }}" name="_token"/>
			
		  <!-- Header  -->
			<div class="row">
			  <div class="col-lg-12">
				<div class="page-header">
				  <h2>User Profile</h2>
				</div>
			  </div>
			</div>


            <div class="row">
               <div class="col-lg-12">

					<input type="hidden" name="txtUserId" id="txtUserId" value="{{ $user->id }}">
					
                        <div class="row">
                           <div class="col-md-6 col-md-offset-3">			
								<div class="form-group">
								  <label for="txtEmail">Email:</label>
								  <input type="text" class="form-control" name="txtEmail" id="txtEmail" maxlength="100" placeholder="Email" value="{{ $user->email }}">
								</div>
                           </div>
						
                           <div class="col-md-6 col-md-offset-3">			
								<div class="form-group">
								  <label for="txtFirstName">First Name:</label>
								  <input type="text" class="form-control" name="txtFirstName" id="txtFirstName" maxlength="50" placeholder="First Name" value="{{ $user->first_name }}">
								</div>
                           </div>
                           <div class="col-md-6 col-md-offset-3">
								<div class="form-group">
								  <label for="txtLastName">Last Name:</label>
								  <input type="text" class="form-control" name="txtLastName" id="txtLastName" maxlength="50" placeholder="Last Name" value="{{ $user->last_name }}">
								</div>
                           </div>

                           <div class="col-md-6 col-md-offset-3">
								<div class="form-group">
								  <label for="txtCompany">Company:</label>
								  <input type="text" class="form-control" name="txtCompany" id="txtCompany" maxlength="50" placeholder="Company Name" value="{{ $user->company }}">
								</div>
                           </div>
						   
                           <div class="col-md-6 col-md-offset-3">
								<div class="form-group">
								  <label for="txtAddress1">Address:</label>
								  <input type="text" class="form-control" name="txtAddress1" id="txtAddress1" maxlength="255" placeholder="" value="{{ $user->address1 }}">
								  <input type="text" class="form-control" name="txtAddress2" id="txtAddress2" maxlength="255" placeholder="" value="{{ $user->address2 }}">
								</div>
                           </div>
						   
                           <div class="col-md-6 col-md-offset-3">
								<div class="form-group">
								  <label for="txtCity">City:</label>
								  <input type="text" class="form-control" name="txtCity" id="txtCity" maxlength="150" placeholder="City" value="{{ $user->city }}">
								</div>
                           </div>

                           <div class="col-md-6 col-md-offset-3">
								<div class="form-group">
								  <label for="txtState">State:</label>
								  <input type="text" class="form-control" name="txtState" id="txtState" maxlength="150" placeholder="State" value="{{ $user->state }}">
								</div>
                           </div>

                           <div class="col-md-6 col-md-offset-3">
								<div class="form-group">
								  <label for="txtCountry">Country:</label>
								  <input type="text" class="form-control" name="txtCountry" id="txtCountry" maxlength="150" placeholder="Country" value="{{ $user->country }}">
								</div>
                           </div>
						   
                           <div class="col-md-6 col-md-offset-3">
								<div class="form-group">
								  <label for="txtPostal">Postal:</label>
								  <input type="text" class="form-control" name="txtPostal" id="txtPostal" maxlength="25" placeholder="Postal Code/Zip" value="{{ $user->postal }}">
								</div>
                           </div>
						   
                           <div class="col-md-6 col-md-offset-3">
                                 <div class="btn-toolbar" role="toolbar">
                                    <button type="submit" class="btn btn-default" name="btnUserProfileSubmit" id="btnUserProfileSubmit">Update</button>
                                 </div>
                           </div>
                        </div><!-- End of Row for user profile input box -->






               </div>
			</div>
		 </form>
      </div>

<!-- End of section for use profile -->


@stop
