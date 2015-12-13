<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Task;
use App\Helpers\Helper as Helper;
use App\Project as Project;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        return view('task.index');
    }
	
	public function postCreate(Request $request)
	{
		$this->validate($request, [
			'txtInputTaskDueDate' => 'required|date',
			//'txtInputDuration' => 'required|numeric',
			'txtInputProjectName' => 'required|min:1|max:255',
			'txtInputTaskDescription' => 'required|min:1|max:512',
		]);

		$task = new Task();
		
		// Manually check duration field for error
		if(isset($_POST['txtInputDuration'])) {
			if(Helper::create()->checkDuration($_POST['txtInputDuration'])){
				$this->validate->getMessageBag()->add('duration', 'Duration format is incorrect (i.e. 0:00:00).');
			} else {
				$task->duration = Helper::create()->getDurationInSeconds($request->input('txtInputDuration'));
			}
		}

		$data = $request->all();	// Get all the request value to pass back to view
		
		if(isset($_POST['txtInputTaskDueDate'])) {
			$task->due_date = $request->input('txtInputTaskDueDate'); // Get the post field from request object
		}
		
		if(isset($_POST['txtInputProjectName'])) {
			// Check to see if a similar project name exists for this user_error
			$project = Project::where('name', '=', $request->input('txtInputProjectName'))
				->where('user_id','=',\Auth::id())
				->first();
			
			if(!$project){
				$project = new Project();
				$project->name = $request->input('txtInputProjectName');
				$project->user_id = \Auth::id();
				$project->save();
			}
			
			$task->project_id = $project->id;
		}		

		if(isset($_POST['txtInputTaskDescription'])) {
			// TODO: Need to create Helper method to parse out tags
			$task->description = $request->input('txtInputTaskDescription'); // Get the post field from request object
		}
		
		//$task->user_id = \Auth::id();
		$task->user()->associate(\Auth::user());
		$task->save(); //Save the record to Task table
		
		// Return a collection of all the tasks for the user
		$tasks = \App\Task::where('user_id','=',\Auth::id())->orderBy('due_date', 'desc');
		

		// $request->flash();	//Send value of input back to form
		// TODO: Send flash message after save/creation
		
		return view('task.index')->with('tasks', $tasks);
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
