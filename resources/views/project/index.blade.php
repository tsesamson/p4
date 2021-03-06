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
		 <form method="post" action="/projects/create">
			<!-- pass through the CSRF (cross-site request forgery) token -->
			<input type="hidden" value="{{ csrf_token() }}" name="_token"/>
			
            <div class="row" style="float:right;">
               <div class="col-lg-12" id="statusMessage" name="statusMessage">
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
                     <div class="panel-body">
                        <div class="row">
                           <div class="col-md-2">
                              <div class="col-md-12">
                                 <div class="input-group">
                                    <span class="input-group-btn">
                                    <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></button>
                                    </span>
                                    <input type="text" class="form-control" name="dueDate" id="dueDate" data-provide="datepicker" maxlength="25" placeholder="Due Date" value="{{ old('dueDate') }}">
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-1">
                              <div class="col-md-12">
                                    <input type="text" class="form-control" name="duration" id="duration" maxlength="25" placeholder="0:00:00" value="{{ old('duration') }}">
                              </div>
                           </div>
                           <div class="col-md-3">
                              <div class="col-md-12">
                                 <input type="text" class="form-control" name="projectName" id="projectName" maxlength="255" placeholder="Project Name" value="{{ old('projectName') }}">
                              </div>
                           </div>
                           <div class="col-md-5">
                              <div class="col-md-12">
                                 <input type="text" class="form-control" name="projectDescription" id="projectDescription" maxlength="255" placeholder="Project Description" value="{{ old('projectDescription') }}">
                              </div>
                           </div>
                           <div class="col-md-1">
                              <div class="col-md-12">
                                 <div class="btn-toolbar" role="toolbar">
                                    <button type="submit" class="btn btn-default" name="btnProjectSubmit" id="btnProjectSubmit"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
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
                  <div class="panel panel-default" id="projectRecord{{$project->id}}" style="margin-top:15px;">
                     <div id="project{{$project->id}}" class="panel-body {{ ($project->status == 'completed')?'bg-success':'' }}">
					 
                        <div class="row" style="padding:15px;">
                           <div class="col-md-2">
                              <div class="col-md-12">
                              	<div id="divName{{$project->id}}"><a href="/projects/edit/{{$project->id}}">{{$project->name}}</a></div>
								<div id="dueDate{{$project->id}}" name="dueDate{{$project->id}}" style="font-size:10px;">Due: {{$project->dueDate()}}</div>
								<!--<input type="text" class="form-control" id="dueDate{{$project->id}}" name="dueDate{{$project->id}}" data-provide="datepicker" style="display:none;" maxlength="25" placeholder="Due Date" value="{{$project->dueDate()}}">-->
                              </div>
                           </div>
                           <div class="col-md-2">
                              <div class="col-md-12">
								<div id="projectDuration{{ $project->id }}" name="projectDuration{{ $project->id }}">{{ $project->durationForHuman() }}</div>
								<!--<input type="text" class="form-control" id="projectDuration{{ $project->id }}" name="projectDuration{{ $project->id }}" maxlength="25" placeholder="0:00" value="{{ ($project->duration)?$project->duration:'' }}">-->
                              </div>
                           </div>
                           <div class="col-md-5">
                              <div class="col-md-12">
								 <!--<input id="txtDescription{{ $project->id }}" type="text" class="form-control" name="txtDescription{{ $project->id }}" style="{{($project->description)?'display:none;':'display:block;'}}" maxlength="255" placeholder="Description or Tags" value="{{ $project->description }}">-->
                                 <div id="divDescription{{ $project->id }}">{{ $project->description }}</div>
                              </div>
                           </div>
                           <div class="col-md-1">
                              <div class="col-md-12">
								<div id="projectStatus{{ $project->id }}" name="projectStatus{{ $project->id }}"><span id="projectStatusBadge{{ $project->id }}" class="badge">{{ $project->status}}</span></div>
								<input id="txtProjectStatus{{ $project->id }}" type="hidden" name="txtProjectStatus{{ $project->id }}" value="{{ $project->status }}">
                              </div>
                           </div>
                           <div class="col-md-2">
                              <div class="col-md-12">
                                 <div class="btn-toolbar" role="toolbar">
									<a href="/projects/edit/{{ $project->id }}" class="btn btn-default"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
                                 	<!--<button id="btnDescription{{ $project->id }}" type="button" class="btn btn-default" onclick="saveTask('{{ $project->id }}');"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button>-->
                                 	<!--<button type="button" class="btn btn-default"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span></button>-->
                                 	<button type="button" class="btn btn-default" onclick="saveProjectStatus({{ $project->id }});"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button>
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
