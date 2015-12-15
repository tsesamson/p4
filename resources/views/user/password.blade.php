@extends('layouts.master')

@section('title')
	Task Driver - User Password Update
@stop

@section('page-title')
	Task Driver
@stop

@section('content')


<!--Section for User password change -->

      <div class="container-fluid">
         <form method="post" action="/users/password">
			<!-- pass through the CSRF (cross-site request forgery) token -->
			<input type="hidden" value="{{ csrf_token() }}" name="_token"/>
			
		  <!-- Header  -->
			<div class="row">
			  <div class="col-lg-12">
				<div class="page-header">
				  <h2>Password Change</h2>
				</div>
			  </div>
			</div>


            <div class="row">
               <div class="col-lg-12">

					<input type="hidden" name="txtUserId" id="txtUserId" value="{{ $user->id }}">
					
                        <div class="row">

                           <div class="col-md-6 col-md-offset-3">			
								<div class="form-group">
								  <label for="old_password">Old Password:</label>
								  <input type="password" class="form-control" name="old_password" id="old_password" maxlength="50" placeholder="" value="">
								</div>
                           </div>
						
                           <div class="col-md-6 col-md-offset-3">			
								<div class="form-group">
								  <label for="password">New Password:</label>
								  <input type="password" class="form-control" name="password" id="password" maxlength="50" placeholder="" value="">
								</div>
                           </div>
                           <div class="col-md-6 col-md-offset-3">
								<div class="form-group">
								  <label for="password_confirmation">Confirm New Password:</label>
								  <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" maxlength="50" placeholder="" value="">
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

<!-- End of section for user password change -->


@stop
