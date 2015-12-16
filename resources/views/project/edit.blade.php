@extends('layouts.master')

@section('title')
	Task Driver - Edit Project '{{ $project->name }}'
@stop

@section('page-title')
	Task Driver
@stop

@section('content')


<!--Section for Edit Project -->

      <div class="container-fluid">
         <form method="post" action="/projects/edit">
			<!-- pass through the CSRF (cross-site request forgery) token -->
			<input type="hidden" value="{{ csrf_token() }}" name="_token"/>
			<input type="hidden" value="{{ $project->id }}" name="projectId" id="projectId" />
			
		  <!-- Header  -->
			<div class="row">
			  <div class="col-lg-12">
				<div class="page-header">
				  <h2>Edit Project</h2>
				</div>
			  </div>
			</div>

            <div class="row">
               <div class="col-lg-12">

					<input type="hidden" name="txtUserId" id="txtUserId" value="{{ $user->id }}">
					
                        <div class="row">

                           <div class="col-md-6 col-md-offset-3">			
								<div class="form-group">
								  <label for="projectName">Project Name:</label>
								  <input type="text" class="form-control" name="projectName" id="projectName" maxlength="50" placeholder="Project Name" value="{{ $project->name }}">
								</div>
                           </div>
                           <div class="col-md-6 col-md-offset-3">
								<div class="form-group">
								  <label for="projectDescription">Description:</label>
								  <input type="text" class="form-control" name="projectDescription" id="projectDescription" maxlength="50" placeholder="Description" value="{{ $project->description }}">
								</div>
                           </div>

                           <div class="col-md-6 col-md-offset-3">
								<div class="form-group">
								  <label for="duration">Duration:</label>
								  <input type="text" class="form-control" id="duration" name="duration" maxlength="25" placeholder="0:00" value="{{ ($project->duration)?$project->duration:'' }}">
								</div>
                           </div>

                           <div class="col-md-6 col-md-offset-3">
								<div class="form-group">
								  <label for="durationLimit">Duration Limit:</label>
								  <input type="text" class="form-control" id="durationLimit" name="durationLimit" maxlength="25" placeholder="0:00" value="{{ ($project->duration_limit)?$project->duration_limit:'' }}">
								</div>
                           </div>
						   
                           <div class="col-md-6 col-md-offset-3">
								<div class="form-group">
								  <label for="startDate">Start Date:</label>
								  <input type="text" class="form-control" id="startDate" name="startDate" data-provide="datepicker" maxlength="15" placeholder="Start Date" value="{{$project->startDate()}}">								  
								</div>
                           </div>

                           <div class="col-md-6 col-md-offset-3">
								<div class="form-group">
								  <label for="endDate">End Date:</label>
								  <input type="text" class="form-control" id="endDate" name="endDate" data-provide="datepicker" maxlength="15" placeholder="End Date" value="{{$project->endDate()}}">								  
								</div>
                           </div>
						   
                           <div class="col-md-6 col-md-offset-3">
								<div class="form-group">
								  <label for="dueDate">Due Date:</label>
								  <input type="text" class="form-control" id="dueDate" name="dueDate" data-provide="datepicker" maxlength="15" placeholder="Due Date" value="{{$project->dueDate()}}">								  
								</div>
                           </div>

						   
                           <div class="col-md-6 col-md-offset-3">
                                 <div class="btn-toolbar" role="toolbar">
                                    <button type="submit" class="btn btn-default" name="btnProjectSubmit" id="btnProjectSubmit">Update Project</button>
                                 </div>
                           </div>
                        </div><!-- End of Row for project input box -->

               </div>
			</div>
		 </form>
      </div>

<!-- End of section for project -->


@stop
