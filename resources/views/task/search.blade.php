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
               </div>
            </div>

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
                     <div id="task{{$task->id}}" class="panel-body {{ ($task->status == 'completed')?'bg-success':'' }}">
                        <div class="row" style="padding:15px;">
                           <div class="col-md-2">
                              <div class="col-md-12">
                              	<div id="divName{{$task->id}}"><strong>{{$task->project->name}}</strong></div>
								<div id="divDueDate{{$task->id}}" name="divDueDate{{$task->id}}" style="font-size:10px;">Due: {{$task->dueDate()}}</div>
								<input type="text" class="form-control" id="dueDate{{$task->id}}" name="dueDate{{$task->id}}" data-provide="datepicker" style="display:none;" maxlength="25" placeholder="Due Date" value="{{$task->dueDate()}}">
                              </div>
                           </div>
                           <div class="col-md-2">
                              <div class="col-md-12">
                                 <div class="input-group">
                                    <input type="text" class="form-control" name="duration{{$task->id}}" id="duration{{$task->id}}" maxlength="25" placeholder="0:00:00" value="{{$task->duration()}}">
                                    <span class="input-group-btn">
									<a id="btnTimerHistory{{$task->id}}" class="btn btn-default" style="{{(count($task->timers) >= 1)?'display:inline-block;':'display:none;'}}" role="button" data-toggle="collapse" data-parent="#taskTimer" href="#collapseTimerHistory{{$task->id}}" aria-expanded="false" aria-controls="collapseTimerHistoryGroup"><span class="glyphicon glyphicon-time"></span></a>                                    
									<button class="btn btn-default" type="button" id="btnduration{{$task->id}}" onclick="startTimer('{{$task->id}}');"><span class="glyphicon glyphicon-play" aria-hidden="true"></span></button>
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
                                 	<button type="button" class="btn btn-default" onclick="saveTaskStatus({{ $task->id }});"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button>
									<input id="txtTaskStatus{{ $task->id }}" type="hidden" name="txtTaskStatus{{ $task->id }}" value="{{ $task->status }}">
									<a href="/tasks/delete/{{ $task->id }}" class="btn btn-default"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
                                 </div>
                              </div>
                           </div>
                        </div><!-- End of Row for task input box -->

                        <!-- Collapsed history section for this task -->

							<div id="collapseTimerHistory{{$task->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
							   <div class="panel-body" id="collapseBodyHistory{{$task->id}}">

								@if(count($task->timers) >= 1)
									@foreach($task->timers as $timer)							   
									   
									  <div class="row" style="padding-top:15px;">
										 <div class="col-md-3">
											<div name="timerDuration{{$timer->id}}" id="timerDuration{{$timer->id}}">
												Logged <strong>{{$timer->duration()}}</strong> - {{$timer->lastUpdatedHuman()}}
											</div>
										 </div>
										 <div class="col-md-7">
											<input type="text" class="form-control" name="timerComment{{$timer->id}}" id="timerComment{{$timer->id}}" maxlength="255" placeholder="Comments ..." value="{{$timer->comment}}">
										 </div>
										 <div class="col-md-2">
											<div class="col-md-12">
											   <div class="btn-toolbar" role="toolbar">
												<button class="btn btn-default" type="button" id="btnTimerComment{{$timer->id}}" onclick="saveTimerComment('{{$timer->id}}');"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span></button>
												<a href="/timers/delete/{{ $timer->id }}" class="btn btn-default"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
											   </div>
											</div>
										 </div>
									  </div>

									@endforeach
								@endif
								  
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
