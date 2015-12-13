@extends('layouts.master')

@section('title')
	Task Driver - Project
@stop

@section('page-title')
	Task Driver
@stop

@section('content')


<!--Section for Project creation and list-->

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
                     <li role="presentation" class="active"><a href="#">Project</a></li>
                     <li role="presentation"><a href="#">Activity</a></li>
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
                                 <input type="text" class="form-control" name="txtInputTaskDescription" id="txtInputTaskDescription" maxlength="255" placeholder="Project Description">
                              </div>
                           </div>
                           <div class="col-md-1">
                              <div class="col-md-12">
                                 <div class="btn-toolbar" role="toolbar">
                                    <button type="submit" class="btn btn-default" name="btnInputTaskSubmit" id="btnInputTaskSubmit"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span></button>
                                 </div>
                              </div>
                           </div>
                        </div><!-- End of Row for project input box -->

                     </div><!--End of panel-body -->
                  </div><!--End of taskTimer panel -->


                  <!-- Header to group the tasks by dates -->
					<div class="row">
				      <div class="col-lg-12">
				        <div class="page-header">
				          <h2>Project List</h2>
				        </div>
				      </div>
				    </div>

				@foreach($projects as $project)
                  <div class="panel panel-default" id="projectList" style="margin-top:15px;">
                     <div class="panel-body">
					 
                        <div class="row" style="padding:15px;">
                           <div class="col-md-2">
                              <div class="col-md-12">
                              	<strong>{{ $project->name }}</strong>
                              </div>
                           </div>
                           <div class="col-md-2">
                              <div class="col-md-12">
								<input type="text" class="form-control" id="projectDuration{{ $project->id }}" name="projectDuration{{ $project->id }}" maxlength="25" placeholder="0:00" value="{{ $project->duration }}">
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="col-md-12">
								 <input id="txtProject{{ $project->id }}Description" type="text" class="form-control" name="txtProject{{ $project->id }}Description" style="display:none;" maxlength="255" placeholder="Description or Tags" value="{{ $project->description }}">
                                 <div id="divProject{{ $project->id }}Description" style="display:block;">{{ $project->description }}</div>
                              </div>
                           </div>
                           <div class="col-md-2">
                              <div class="col-md-12">
                                 <div class="btn-toolbar" role="toolbar">
                                 	<button id="btnProject{{ $project->id }}Description" type="button" class="btn btn-default" onclick="saveTask('Project{{ $project->id }}Description');"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button>
                                 	<!--<button type="button" class="btn btn-default"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span></button>-->
                                 	<button type="button" class="btn btn-default"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button>
                                    <a href="/projects/delete/{{ $project->id }}" class="btn btn-default"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
                                 </div>
                              </div>
                           </div>
                        </div><!-- End of Row for project input box -->

                     </div><!--End of panel-body -->
                  </div><!--End of projectList panel -->
				@endforeach

               </div>
			</div>
		 </form>
      </div>

<!-- End of section for project creation and list -->


@stop
