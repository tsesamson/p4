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
		
			@if(Session::has('flash_message'))
            <div class="container-fluid">
				<div class="row">
					<!--<div class="page-header" style="border-bottom:0px;">-->
						<! --{{ Session::get('alert-class', 'alert-info') }} -->
					   <div class="alert alert-warning alert-dismissible fade in" id="flash_message" role="alert">
						  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
						  <span aria-hidden="true">&times;</span></button>{{ Session::get('flash_message') }}
					   </div>
					<!--</div>-->
				 </div>           
            </div>
			@endif
			
			<!--<div class="title">
				@yield('page-title', "P4: Task Driver")
			</div>-->
			
			@yield('content')
        </div>
   
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.min.js"></script>
		<script src="assets/js/taskdriver.js"></script>
		<script type="text/javascript">
			//Custom code if any
		</script>
	
	</body>
</html>
