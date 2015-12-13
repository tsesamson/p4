@extends('layouts.master')

@section('title')
	Task Driver
@stop

@section('page-title')
	Task Driver
@stop

@section('content')

@include('layouts.nav.main')


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

<!--Section for Task creation and timer-->

      <div class="container-fluid">
         <form method="post" action="/tasks/create">
			<!-- pass through the CSRF (cross-site request forgery) token -->
			<input type="hidden" value="{{ csrf_token() }}" name="_token"/>
			
            <div class="row" style="float:right;">
               <div class="col-lg-12" id="statusMessage" name="statusMessage">
                  logged <strong>6 hours</strong> today - last entry <strong>29 minutes ago</strong>
               </div>
            </div>

            <div class="row">
               <div class="col-lg-12">
                  <!-- Navigation bar above input box-->
                  <ul class="nav nav-tabs">
                     <li role="presentation" class="active"><a href="#">Task</a></li>
                     <li role="presentation"><a href="#">Activities</a></li>
                  </ul>
                  <div class="panel panel-default" id="taskTimer" style="margin-top:15px;">
                     <!--<div class="panel-heading"><h2 class="panel-title">Task</h2></div>-->
                     <div class="panel-body">
                        <div class="row">
                           <div class="col-md-2">
                              <div class="col-md-12">
                                 <div class="input-group">
                                    <span class="input-group-btn">
                                    <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></button>
                                    </span>
                                    <input type="text" class="form-control" name="txtInputTaskDueDate" id="txtInputTaskDueDate" data-provide="datepicker" maxlength="25" placeholder="Due Date" value="">
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-1">
                              <div class="col-md-12">
                                    <input type="text" class="form-control" name="txtInputDuration" id="txtInputDuration" maxlength="25" placeholder="0:00" value="">
                              </div>
                           </div>
                           <div class="col-md-3">
                              <div class="col-md-12">
                                 <input type="text" class="form-control" name="txtInputProjectName" id="txtInputProjectName" maxlength="255" placeholder="Project Name" value="">
                              </div>
                           </div>
                           <div class="col-md-5">
                              <div class="col-md-12">
                                 <input type="text" class="form-control" name="txtInputTaskDescription" id="txtInputTaskDescription" maxlength="255" placeholder="Tags or Description">
                              </div>
                           </div>
                           <div class="col-md-1">
                              <div class="col-md-12">
                                 <div class="btn-toolbar" role="toolbar">
                                    <button type="submit" class="btn btn-default" name="btnInputTaskSubmit" id="btnInputTaskSubmit"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span></button>
                                 </div>
                              </div>
                           </div>
                        </div><!-- End of Row for task input box -->

                     </div><!--End of panel-body -->
                  </div><!--End of taskTimer panel -->


                  <!-- Header to group the tasks by dates -->
					<div class="row">
				      <div class="col-lg-12">
				        <div class="page-header">
				          <h2>December 12, 2015</h2>
				        </div>
				      </div>
				    </div>

                  <div class="panel panel-default" id="taskTimerRecord" style="margin-top:15px;">
                     <!--<div class="panel-heading"><h2 class="panel-title">Task</h2></div>-->
                     <div class="panel-body">
                        <div class="row" style="padding:15px;">
                           <div class="col-md-2">
                              <div class="col-md-12">
                              	<strong>Sample Project</strong>
                                 <!--<div class="input-group">
                                    <span class="input-group-btn">
                                    <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></button>
                                    </span>
                                    <input type="text" class="form-control" name="taskDate"  data-provide="datepicker" maxlength="25" placeholder="" value="">
                                 </div>-->
                              </div>
                           </div>
                           <div class="col-md-2">
                              <div class="col-md-12">
                                 <div class="input-group">
                                    <input type="text" class="form-control" name="duration" maxlength="25" placeholder="0:00" value="">
                                    <span class="input-group-btn">
                                    <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-play" aria-hidden="true"></span></button>
                                    <a class="btn btn-default" role="button" data-toggle="collapse" data-parent="#taskTimer" href="#collapseTimerHistory" aria-expanded="false" aria-controls="collapseTimerHistoryGroup"><span class="glyphicon glyphicon-time"></span></a>
                                    </span>
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="col-md-12">
								 <input id="txtTaskDescription" type="text" class="form-control" name="txtTaskDescription" style="display:none;" maxlength="255" placeholder="Description or Tags" value="This is the description for the task with #tag marking tags within the description.  I'll need to parse the tags out and add it to its own table. Assigned to #tse.samson@gmail.com">
                                 <div id="divTaskDescription" style="display:block;">This is the description for the task with #tag marking tags within the description.  I'll need to parse the tags out and add it to its own table. Assigned to #tse.samson@gmail.com</div>
                              </div>
                           </div>
                           <div class="col-md-2">
                              <div class="col-md-12">
                                 <div class="btn-toolbar" role="toolbar">
                                 	<button id="btnTaskDescription" type="button" class="btn btn-default" onclick="saveTask('TaskDescription');"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button>
                                 	<!--<button type="button" class="btn btn-default"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span></button>-->
                                 	<button type="button" class="btn btn-default"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button>
                                    <button type="button" class="btn btn-default"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                                 </div>
                              </div>
                           </div>
                        </div><!-- End of Row for task input box -->

                        <!-- Collapsed history section for this task -->
                        <div id="collapseTimerHistory" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                           <div class="panel-body">
                              <div class="row" style="padding-top:15px;">
                                 <div class="col-md-2">01/20/2016</div>
                                 <div class="col-md-2">
									 <div class="input-group">
										<input type="text" class="form-control" name="duration" maxlength="25" placeholder="0:00" value="0:45">
										<span class="input-group-btn">
										<button class="btn btn-default" type="button"><span class="glyphicon glyphicon-play" aria-hidden="true"></span></button>
										</span>
									 </div>
								 </div>
                                 <div class="col-md-6">This is the description for the task with <span class="label label-warning">#tag</span> marking tags within the description.  Will need to parse the tags out and add it to its own table.</div>
                                 <div class="col-md-2">
                                    <div class="col-md-12">
                                       <div class="btn-toolbar" role="toolbar">
                                          <!--<button type="submit" class="btn btn-danger btn-md btn-block">Delete</button>-->
                                          <button type="button" class="btn btn-default"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="row" style="padding-top:15px;">
                                 <div class="col-md-2">01/01/2016</div>
                                 <div class="col-md-2">
									 <div class="input-group">
										<input type="text" class="form-control" name="duration" maxlength="25" placeholder="0:00" value="0:12">
										<span class="input-group-btn">
										<button class="btn btn-default" type="button"><span class="glyphicon glyphicon-play" aria-hidden="true"></span></button>
										</span>
									 </div>
								 </div>
                                 <div class="col-md-6">This is the description for the task with #tag marking tags within the description.  Will need to parse the tags out and add it to its own table.</div>
                                 <div class="col-md-2">
                                    <div class="col-md-12">
                                       <div class="btn-toolbar" role="toolbar">
                                          <!--<button type="submit" class="btn btn-danger btn-md btn-block">Delete</button>-->
                                          <button type="button" class="btn btn-default"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div><!--End of panel-body -->
                        </div><!--End of collapseTimeHistory -->

                     </div><!--End of panel-body -->
                  </div><!--End of taskTimerRecord panel -->


               </div>
			</div>
		 </form>
      </div>

<!-- End of section for task creation and timer -->


@stop
