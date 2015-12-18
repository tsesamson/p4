<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Project as Project;
use App\Task as Task;
use App\Helpers\Helper as Helper;
use Carbon\Carbon;
use Debugbar;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
		//Debugbar::info(\Auth::id());
		// Return a collection of all the projects for the user
		$projects = Project::where('user_id','=',\Auth::id())->orderBy('due_date', 'desc')->get();
		
		return view('project.index')->with('projects', $projects);
    }
	
	public function postCreate(Request $request)
	{
		$this->validate($request, [
			'dueDate' => 'required|date',
			//'duration' => 'numeric',
			'projectName' => 'required|min:1|max:255',
			'projectDescription' => 'required|min:1|max:512',
			'duration' => array('regex:/^(?:(?:([01]?\d|2[0-3]):)?([0-5]?\d):)?([0-5]?\d)$/'), //Change to regex duration format check instead
		]);

		$project = new Project();
		
		// Manually check duration field for error
		if(isset($_POST['duration'])) {
			//if(Helper::create()->checkDuration($_POST['txtInputDuration'])){
			//	$this->validate->getMessageBag()->add('duration', 'Duration format is incorrect (i.e. 0:00:00).');
			//} else {
				$project->duration = Helper::create()->getDurationInSeconds($request->input('duration'));
			//}
		}
		
		$data = $request->all();	// Get all the request value to pass back to view
		
		if(isset($_POST['dueDate'])) {
			Debugbar::info($_POST['dueDate']);
			$project->start_date = Carbon::now();
			$project->due_date = Carbon::parse($request->input('dueDate')); // Get the post field from request object
		}
		
		if(isset($_POST['projectName'])) {
			// Check to see if a similar project name exists for this user
			$projectCheck = Project::where('name', '=', $request->input('projectName'))
				->where('user_id','=',\Auth::id())
				->first();
			
			if(!$projectCheck){
				$project->name = $request->input('projectName');
				// Associate this user with all the proper user_id fields
				$project->user_id = \Auth::id();
				$project->created_by = \Auth::id();
				$project->updated_by = \Auth::id();
				
			}
		}		

		$project->description = $request->input('projectDescription'); // Get the post field from request object
		
		//Make sure the saving is done in a transaction so any error will be rollback
		\DB::transaction(function() use ($project) {
			$project = $project->save();  
		});
		
		// Set the flash message for completing the save
		$request->session()->flash('alert-success', "Project '" . $project->name . "' added successfully.");
		
		
		return redirect('projects');
		//return view('project.index')->with('projects', $projects);
	}
	
	
	/*
	 * Get the project record for editing
	 */
	public function getEdit($id)
	{
		$project = Project::findOrFail($id);
		
		return view('project.edit')->with('project', $project);
	}
	
	/* 
	 * Receives project form update thru post
	 */
	public function postEdit(Request $request)
	{
		$this->validate($request, [
			'projectId' => 'required|numeric',
			'projectName' => 'required|min:1|max:255',
			'projectDescription' => 'required|min:1|max:512',
			//'startDate' => 'required|date',
			//'endDate' => 'required|date',
			'dueDate' => 'required|date',
			'duration' => array('regex:/^(?:(?:([01]?\d|2[0-3]):)?([0-5]?\d):)?([0-5]?\d)$/'), //Change to regex duration format check instead
		]);

		$project = Project::find($request->input('projectId'));
		
		// Manually check duration field for error
		if(isset($_POST['duration'])) {
			//if(Helper::create()->checkDuration($_POST['txtInputDuration'])){
			//	$this->validate->getMessageBag()->add('duration', 'Duration format is incorrect (i.e. 0:00:00).');
			//} else {
				$project->duration = Helper::create()->getDurationInSeconds($request->input('duration'));
				
			//}
		}
		
		if(isset($_POST['durationLimit'])){
			$project->duration_limit = Helper::create()->getDurationInSeconds($request->input('durationLimit'));
		}
		
		$data = $request->all();	// Get all the request value to pass back to view
		
		if(isset($_POST['dueDate'])) {
			//Debugbar::info($_POST['dueDate']);
			$project->start_date = Carbon::parse($request->input('startDate'));
			$project->end_date = Carbon::parse($request->input('endDate'));
			$project->due_date = Carbon::parse($request->input('dueDate')); // Get the post field from request object
		}
		
		if(isset($_POST['projectName'])) {
			// Check to see if a similar project name exists for this user
			$projectCheck = Project::where('name', '=', $request->input('projectName'))
				->where('user_id','=',\Auth::id())
				->first();
			
			if(!$projectCheck){
				$project->name = $request->input('projectName');
			}
		}		

		$project->description = $request->input('projectDescription'); // Get the post field from request object
		$project->updated_by = \Auth::id();
		
		//Make sure the saving is done in a transaction so any error will be rollback
		\DB::transaction(function() use ($project) {
			$project = $project->save();  
		});
		
		// Set the flash message for completing the save
		$request->session()->flash('alert-success', "Project '" . $project->name . "' updated successfully.");
		
		$request->flash();	//Send value of input back to 
		
		//return redirect('projects');
		return view('project.edit')->with('project', $project);
	}
		
	
	/*
	 * Status update of the project that returns an ajax response
	 */
	public function ajaxStatus($id, Request $request)
	{
		$project = Project::findOrFail($id);
		
		if($project && isset($_POST['status'])) {
			try {
				$project->updated_by = \Auth::id();
				$project->status = $request->input('status');
				$project->save();
			} catch(Exception $e){
				$data = array('error' => 'Unable to update project status.');		
				//return  Response::json($data, 500);
			}
		}
		
		// Pass back some data, along with the original data, just to prove it was received
		$data = array('success' => 'Project status updated successfully.', 'id' => $id, 'input' => $request->input());
		
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
    public function getDelete($id)
    {
        $project = Project::where('id', '=', $id)
			->where('user_id', '=', \Auth::id())
			->first();
		
		// Set the flash message for completing the deletion
		\Session::flash('alert-success', "Project '" . $project->name . "' deleted successfully.");
			
		$project->delete(); // Delete the project
		
		// Return a collection of all the projects for the user
		$projects = Project::where('user_id','=',\Auth::id())->orderBy('due_date', 'desc')->get();
		
		return view('project.index')->with('projects', $projects);
    }
}
