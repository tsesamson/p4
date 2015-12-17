<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Task as Task;
use App\Timer as Timer;
use App\Helpers\Helper as Helper;
use Carbon\Carbon;
use Debugbar;

class TimerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
	
	/*
	 * Start a new timer for a specific task with ajax call
	 */
	public function ajaxStart($id, Request $request)
	{
		$task = Task::findOrFail($id);
		$timers = Timer::where('task_id', '=', $id)->where('duration', '=', 0)->whereNotNull('start')->get();
		
		
		// If there's a lingering timer, we have to stop it out
		if($task && count($timers)>0) {
			foreach($timers as $timer){
				$timer->stop();
			}
		}
		
		if($task){
			try {
				$timer = new Timer();
				$timer->start();
				$timer->project_id = $task->project_id;
				$task->timers()->save($timer);
				
			} catch(Exception $e){
				$data = array('error' => 'Unable to start timer.');		
			}
		}
		
		// Pass back some data, along with the original data, just to prove it was received
		$data = array('success' => 'Timer started successfully.', 'timer' => $timer, 'input' => $request->input());
		
		// Return the success JSON response
		return response()->json($data, 200);
	}
	
	/*
	 * Stop a timer for a specific task with ajax call
	 */
	public function ajaxStop($task_id, Request $request)
	{
		$task = Task::with('project')->findOrFail($task_id);
		$timers = Timer::where('task_id', '=', $task_id)->where('duration', '=', 0)->whereNotNull('start')->get();
		
		// If there's a lingering timer, we have to stop it out
		if($task && count($timers)>0) {
			foreach($timers as $timer){
				$timer->stop();
			}
		}
		
		// Update task duration with new timer logged
		$task->duration += $timer->duration;
		$task->save();
		// Update project duration with new timer logged
		$task->project->duration += $timer->duration;
		$task->project->save();
		
		$data = array('success' => 'Timer stopped successfully.', 'timer' => $timer, 'input' => $request->input());
		
		// Return the success JSON response
		return response()->json($data, 200);
	}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
