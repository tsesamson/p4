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
			
            <!--<div class="row" style="float:right;">
               <div class="col-lg-12" id="statusMessage" name="statusMessage">
                  logged <strong>6 hours</strong> today - last entry <strong>29 minutes ago</strong>
               </div>
            </div>-->



			<!-- Header to group the tasks by dates -->
			<div class="row">
			  <div class="col-lg-12">
				<div class="page-header">
					@if($isTagSearch)
						<h2>Search result for #{{ $hashTag }}</h2>
					@else
						<h2>Search result for '{{ $hashTag }}'</h2>
					@endif
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
                                    <input type="text" class="form-control" name="duration{{$task->id}}" id="duration{{$task->id}}" maxlength="25" placeholder="0:00" value="{{$task->duration()}}">
                                    <span class="input-group-btn">
                                    <button class="btn btn-default" type="button" id="btnduration{{$task->id}}" onclick="startTimer('duration{{$task->id}}');"><span class="glyphicon glyphicon-play" aria-hidden="true"></span></button>
                                    <a class="btn btn-default" style="{{(count($task->timers) > 1)?'display:inline-block;':'display:none;'}}" role="button" data-toggle="collapse" data-parent="#taskTimer" href="#collapseTimerHistory" aria-expanded="false" aria-controls="collapseTimerHistoryGroup"><span class="glyphicon glyphicon-time"></span></a>
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
									<a href="/tasks/delete/{{ $task->id }}" class="btn btn-default"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
                                 </div>
                              </div>
                           </div>
                        </div><!-- End of Row for task input box -->

                        <!-- Collapsed history section for this task -->
						@if(count($task->timers) > 1)
							@foreach($task->timers as $timer)
							<div id="collapseTimerHistory" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
							   <div class="panel-body">
								  <div class="row" style="padding-top:15px;">
									 <div id="timerStart{{$timer->id}}" class="col-md-2">{{$timer->startDate()}}</div>
									 <div class="col-md-2">
										<div name="timerDuration{{$timer->id}}" id="timerDuration{{$timer->id}}">{{$timer->duration()}}</div>
									 </div>
									 <div id="timerComment{{$timer->id}}" class="col-md-6">
										<input type="text" class="form-control" name="timerComment{{$timer->id}}" id="timerComment{{$timer->id}}" maxlength="255" placeholder="Comments ..." value="{{$timer->comment}}">
									 </div>
									 <div class="col-md-2">
										<div class="col-md-12">
										   <div class="btn-toolbar" role="toolbar">
											  <button type="button" id="btnTimerDelete{{$timer->id}}" class="btn btn-default"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
										   </div>
										</div>
									 </div>
								  </div>						
							   </div><!--End of panel-body -->
							</div><!--End of collapseTimeHistory -->
							@endforeach
						@endif

                     </div><!--End of panel-body -->
                  </div><!--End of taskTimerRecord panel -->
				@endforeach
			@endif
		 </form>
      </div>

<!-- End of section for task creation and timer -->


@stop
