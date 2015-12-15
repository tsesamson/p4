@extends('layouts.master')

@section('title')
	Task Driver - Hashtag search result
@stop

@section('page-title')
	Task Driver
@stop

@section('content')

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



			<!-- Header to group the tasks by dates -->
			<div class="row">
			  <div class="col-lg-12">
				<div class="page-header">
				  <h2>Search result for #{{ $hashTag }}</h2>
				</div>
			  </div>
			</div>


			@if(count($tasks)==0) 
			
                  <div class="panel panel-default" id="taskTimerRecord" style="margin-top:15px;">
                     <div class="panel-body">
                        <div class="row" style="padding:15px;">
                           <div class="col-md-12">
                              	<strong>We are unable to locate any task with #{{$hashTag}}.</strong>
                           </div>
						</div>
					</div>
				</div>
			
			@else
				@foreach($tasks as $task)
			
                  <div class="panel panel-default" id="taskRecord{{$task->id}}" style="margin-top:15px;">
                     <div class="panel-body">
                        <div class="row" style="padding:15px;">
                           <div class="col-md-2">
                              <div class="col-md-12">
                              	<div id="divName{{$task->id}}"><strong>{{$task->project->name}}</strong></div>
								<input type="text" class="form-control" id="dueDate{{$task->id}}" name="dueDate{{$task->id}}" data-provide="datepicker" style="display:none;" maxlength="25" placeholder="Due Date" value="{{$task->dueDate()}}">
                              </div>
                           </div>
                           <div class="col-md-2">
                              <div class="col-md-12">
                                 <div class="input-group">
                                    <input type="text" class="form-control" name="txtDuration{{$task->id}}" maxlength="25" placeholder="0:00" value="{{$task->duration()}}">
                                    <span class="input-group-btn">
                                    <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-play" aria-hidden="true"></span></button>
                                    <a class="btn btn-default" role="button" data-toggle="collapse" data-parent="#taskTimer" href="#collapseTimerHistory" aria-expanded="false" aria-controls="collapseTimerHistoryGroup"><span class="glyphicon glyphicon-time"></span></a>
                                    </span>
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="col-md-12">
								 <input id="txtDescription{{$task->id}}" type="text" class="form-control" name="txtDescription{{$task->id}}" style="display:none;" maxlength="255" placeholder="Description or Tags" value="{{$task->description}}">
                                 <div id="divDescription{{$task->id}}" style="display:block;">{{$task->description}}</div>
                              </div>
                           </div>
                           <div class="col-md-2">
                              <div class="col-md-12">
                                 <div class="btn-toolbar" role="toolbar">
                                 	<button id="btnDescription{{$task->id}}" type="button" class="btn btn-default" onclick="saveTask('{{$task->id}}');"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button>
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
				@endforeach
			@endif
		 </form>
      </div>

<!-- End of section for task creation and timer -->


@stop
