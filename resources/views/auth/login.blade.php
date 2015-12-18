@extends('layouts.master')

@section('title')
	Task Driver - Login
@stop

@section('page-title')
	Task Driver
@stop

@section('content')

<div class="container-fluid">
	<div style="margin-top: 50px; margin-bottom: 50px;">
		<img style="display: block; margin-left: auto; margin-right: auto;border:0px;;max-width:608px;" class=""
			 src="/assets/img/td_logo.png"
			 alt="" />
	</div>
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
		<form method='POST' action='/login'>
			{!! csrf_field() !!}

			<div class="login-bg">
				<fieldset>

					<legend>
						<h2>Sign in with your TaskDriver Account</h2>
					</legend>
					<p>
						Don't have an account? <a href='/register'>Register here...</a><br>
					</p>
					<div class="editor-field">
						<input type="text" class="form-control" style="display:inline;height:37px;font-size:18px;" placeholder="Email Address" name='email' id='email' value='{{ old('email') }}'>
						<input type="password" class="form-control" name="password" style="display:inline;height:37px;font-size:18px;" id="password" value="{{ old('password') }}" placeholder = "********">
						<span class="span3" style="display: inline; float: right; margin-top:3px">
							<button type='submit' class='btn btn-primary'>Sign In</button>
						</span>
					</div>
					<div class="editor-field">
						<!--<span class="help-block"><a href="/forgot">Forgot Password</a></span>-->
						<div class="checkbox">
							<label class="checkbox-custom">
								<input type='checkbox' name='remember' id='remember'> <strong>Remember me</strong>
							</label>
						</div>
					</div>
				</fieldset>
			</div>	

		</form>
		</div>
	</div>
</div>
@stop