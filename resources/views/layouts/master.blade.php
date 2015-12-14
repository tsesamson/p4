<!DOCTYPE html>
<html>
    <head>
        <title>
		@yield('title', "P4: Task Driver")
		</title>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker3.standalone.min.css">
	<!--<link href="//netdna.bootstrapcdn.com/bootswatch/3.1.1/flatly/bootstrap.min.css" rel="stylesheet">-->

	<link href="/assets/css/taskdriver.css" rel="stylesheet" type="text/css">

	</head>
	<body>
	
        <div class="container">
			
			<!--<div class="title">
				@yield('page-title', "P4: Task Driver")
			</div>-->
			@if($user)
				@include('layouts.nav.main')
			@endif

			@foreach (['danger', 'warning', 'success', 'info'] as $msg)
			  @if(Session::has('alert-' . $msg))
				<div class="container-fluid">
					<div class="row">
						   <div class="alert alert-{{ $msg }} alert-dismissible fade in" id="flash_message" role="alert">
							  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
							  <span aria-hidden="true">&times;</span></button>
							  {{ Session::get('alert-' . $msg) }}
						   </div>
					 </div>           
				</div>
			  @endif
			@endforeach
			
			@if(Session::has('flash_message'))
			<div class="container-fluid">
				<div class="row">
						<! --{{ Session::get('alert-class', 'alert-info') }} -->
					   <div class="alert alert-warning alert-dismissible fade in" id="flash_message" role="alert">
						  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
						  <span aria-hidden="true">&times;</span></button>{{ Session::get('flash_message') }}
					   </div>
				 </div>           
			</div>
			@endif

			@if(count($errors) > 0)
			<div class="container-fluid">
				<div class="row">
					<div class="alert alert-danger alert-dismissible fade in" id="flash_message" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span></button>
						<ul>
							@foreach($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
				</div>
			</div>
			@endif
			
			@yield('content')
        </div>
   
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.min.js"></script>
		<script src="/assets/js/taskdriver.js"></script>
		<script type="text/javascript">
			// set up jQuery with the CSRF token, or else post routes will fail
			$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('input[name="csrf-token"]').attr('content') } });
		</script>
	
	</body>
</html>
