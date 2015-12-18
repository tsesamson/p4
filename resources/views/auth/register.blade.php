@extends('layouts.master')

@section('content')

<div class="container-fluid">
	<div style="margin-top: 50px; margin-bottom: 50px;">
		<img style="display: block; margin-left: auto; margin-right: auto;border:0px;;max-width:608px;" class=""
			 src="/assets/img/td_logo.png"
			 alt="" />
	</div>
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
		<form method='POST' action='/register'>
			{!! csrf_field() !!}

			<div class="login-bg">
				<fieldset>

					<legend>
						<h2>Register your TaskDriver Account</h2>
					</legend>
					<p>
						Already have an account? <a href='/login'>Login here...</a><br>
					</p>
					<div class='form-group'>
						<label for='name'>First Name</label>
						<input class="form-control" type='text' name='first_name' id='first_name' value='{{ old('first_name') }}'>
					</div>
					
					<div class='form-group'>
						<label for='name'>Last Name</label>
						<input class="form-control" type='text' name='last_name' id='last_name' value='{{ old('last_name') }}'>
					</div>
					
					<div class='form-group'>
						<label for='email'>Email</label>
						<input class="form-control" type='text' name='email' id='email' value='{{ old('email') }}'>
					</div>
					
					<div class='form-group'>
						<label for='password'>Password</label>
						<input class="form-control" type='password' name='password' id='password'>
					</div>

					<div class='form-group'>
						<label for='password_confirmation'>Confirm Password</label>
						<input class="form-control" type='password' name='password_confirmation' id='password_confirmation'>
					</div>
					
					<div class="editor-field">
						<span class="span3" style="display: inline; float: right; margin-top:3px">
							<button type='submit' class='btn btn-primary'>Register</button>
						</span>
					</div>
				</fieldset>
			</div>	

		</form>
		</div>
	</div>
</div>


@stop
