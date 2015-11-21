<!DOCTYPE html>
<html>
    <head>
        <title>
		@yield('title', "P4: Task Driver")
	</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
        
	<link href="/css/p4.css" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<link href="//netdna.bootstrapcdn.com/bootswatch/3.1.1/flatly/bootstrap.min.css" rel="stylesheet">
	</head>
    <body>

@if(Session::has('flash_message'))
<div class="alert alert-warning">
    <a href="#" class="close" data-dismiss="alert">&times;</a>
    {{ Session::get('flash_message') }}
</div>
<! --{{ Session::get('alert-class', 'alert-info') }} -->
@endif
	<div>@yield('home-link')</div>
        <div class="container">
            <div class="content">
                <div class="title">
			@yield('page-title', "P4: Task Driver")
		</div>

		@yield('content')


            </div>
        </div>
   <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script> </body>
</html>
