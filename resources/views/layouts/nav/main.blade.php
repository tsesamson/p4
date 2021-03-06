      <nav class="navbar navbar-default">
         <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
               <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
               <span class="sr-only">Toggle navigation</span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
               </button>
               <a class="navbar-brand" href="#">Task Driver</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
               <ul class="nav navbar-nav">
                  <li class="{{ Helper::set_active(['home','tasks','tasks/*','tasks/show/*']) }}"><a href="/home">Log Time <span class="sr-only">(current)</span></a></li>
                  <li class="{{ Helper::set_active(['projects','projects/*','projects/show/*']) }}"><a href="/projects">Projects</a></li>
                  <li><a href="#">Reports</a></li>
               </ul>
               <form class="navbar-form navbar-left" role="search" method="post" action="/tasks/search">
                  <div class="form-group">
					<input type="hidden" value="{{ csrf_token() }}" name="_token"/>
					<div class="input-group">
						<input type="text" id="txtHashTagSearch" name="txtHashTagSearch" class="form-control" data-provide="typeahead" placeholder="Search tag or project name">
						<span class="input-group-btn">
							<button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>	
						</span>
					</div>
                  </div>
                  
				  
               </form>
               <ul class="nav navbar-nav navbar-right">
                  <!--<li><a href="#">Link</a></li>-->
                  <li class="dropdown">
                     <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ $user->email }} <span class="caret"></span></a>
                     <ul class="dropdown-menu">
                        <li><a href="/users/profile">Profile</a></li>
                        <li><a href="/users/password">Password Change</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="/logout">Logout</a></li>
                     </ul>
                  </li>
               </ul>
               </li>
               </ul>
            </div>
            <!-- /.navbar-collapse -->
         </div>
         <!-- /.container-fluid -->
      </nav>
