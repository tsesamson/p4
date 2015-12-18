<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Tag as Tag;
use App\Task as Task;
use App\Helpers\Helper as Helper;
use App\Project as Project;
use Carbon\Carbon;
use Debugbar;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
		$tasks = Task::with('timers')->where('user_id', '=', \Auth::id())->orderBy('due_date', 'desc')->get();
		
        return view('task.index')->with('tasks', $tasks);
    }
	
	public function postCreate(Request $request)
	{
		$this->validate($request, [
			'dueDate' => 'required|date',
			//'txtInputDuration' => 'required|numeric',
			'projectName' => 'required|min:1|max:255',
			'taskDescription' => 'required|min:1|max:512',
			'duration' => array('regex:/^(?:(?:([01]?\d|2[0-3]):)?([0-5]?\d):)?([0-5]?\d)$/'), //Change to regex duration format check instead
		]);

		$task = new Task();
		
		// Associate this user with all the proper user_id fields
		$task->user_id = \Auth::id();
		$task->created_by = \Auth::id();
		$task->updated_by = \Auth::id();
		//$task->assigned_to = \Auth::id();
		
		// Manually check duration field for error
		if(isset($_POST['duration'])) {
			//if(Helper::create()->checkDuration($_POST['txtInputDuration'])){
			//	$this->validate->getMessageBag()->add('duration', 'Duration format is incorrect (i.e. 0:00:00).');
			//} else {
				$task->duration = Helper::create()->getDurationInSeconds($request->input('duration'));
			//}
		}

		$data = $request->all();	// Get all the request value to pass back to view
		
		if(isset($_POST['dueDate'])) {
			Debugbar::info($_POST['dueDate']);
			$task->start_date = Carbon::now();
			$task->due_date = Carbon::parse($request->input('dueDate')); // Get the post field from request object
		}
		
		if(isset($_POST['projectName'])) {
			// Check to see if a similar project name exists for this user_error
			$project = Project::where('name', '=', $request->input('projectName'))
				->where('user_id','=',\Auth::id())
				->first();
			
			if(!$project){
				$project = new Project();
				$project->name = $request->input('projectName');
				$project->duration = 0;
				$project->user_id = \Auth::id();
				$project->created_by = \Auth::id();
			}
			
			$project->duration += $task->duration; //Add the task duration to the project duration
			$task->project_id = $project->id;
			$project->updated_by = \Auth::id();
		}		

		$hashTags = array();
		if(isset($_POST['taskDescription'])) {
			$hashTags = Helper::create()->getTagsFromString($request->input('taskDescription'));  // Get the hashtags from description
			$task->description = $request->input('taskDescription'); // Get the post field from request object
		}

		//Make sure the saving is done in a transaction so any error will be rollback
		\DB::transaction(function() use ($project, $task, $hashTags) {
			//$project = $project->save();  // Project needs to exists first
			$project->save();  // Project needs to exists first
			Project::find($project->id)->tasks()->save($task); // Task is saved to existing Project record
			
			
			// TODO: If tag name is an email, add user to assigned_to field
			foreach($hashTags as $tagName){
				$tag = Tag::where('name', '=', $tagName)
					->where('user_id', '=', \Auth::id())->first();
				
				if($tag) {
					$task->tags()->save($tag);  // Save tag to task
				} else {
					$tag = new Tag();  // Create new tag
					$tag->name = $tagName;
					$tag->user_id = \Auth::id();
					$task->tags()->save($tag);
					//$tag->save();
				}
			}
			
			//$task->user_id = \Auth::id();
			//$task->user()->associate(\Auth::user());
			//$task->save(); //Save the record to Task table
			
		});
		
		// Set the flash message for completing the save
		$request->session()->flash('alert-success', "Task added successfully for '" . $project->name . "'.");
		
		// Return a collection of all the tasks for the user
		$tasks = Task::where('user_id','=',\Auth::id())->orderBy('due_date', 'desc')->get();
		

		$request->flash();	//Send value of input back to form
		// TODO: Send flash message after save/creation
		
		return redirect('home');
		//return view('task.index')->with('tasks', $tasks);
	}

    /**
     * Display all tasks with specific hashtag
     *
     * @param  varchar  $tag
     * @return \Illuminate\Http\Response
     */
    public function postSearch(Request $request)
    {
		$hashTag = "";
		$isTagSearch = true;
		
		if(isset($_POST['txtHashTagSearch'])) {
				$hashTag = $request->input('txtHashTagSearch');
				
				// Strip away the initial '#' if it exist in search text
				while(substr($hashTag, 0, 1) === "#"){
					$hashTag = substr($hashTag, 1);
				}
		}
		
		// Return a collection of all the tasks for the user with specific hashtag
		$tags = Tag::with('tasks.project')->where('user_id','=',\Auth::id())->where('name','=',$hashTag)->get();
		
		$request->flash();	//Send value of input back to form
		
		Debugbar::info($tags);
		$tasks = array(); // Array to hold all tasks from search result
		
		foreach($tags as $tag){
			foreach($tag->tasks as $task){
				array_push($tasks, $task);
			}
		}
		
		// Check to see if result set is empty, if so, proceed to search tasks from project name
		if(count($tasks)==0){
			$project = Project::where('name','=',$hashTag)->first();
			if($project) {
				$tasks = Project::find($project->id)->tasks;
				$isTagSearch = false;
			}
		}
		
		if(count($tasks)==0){ $isTagSearch = false; }
		
		return view('task.search')->with('tasks', $tasks)->with('hashTag', $hashTag)->with('isTagSearch', $isTagSearch);
    }

	/*
	 * Status update of the task that returns an ajax response
	 */
	public function ajaxUpdate($id, Request $request)
	{
		$task = Task::findOrFail($id);
		
		if($task && isset($_POST['description']) && isset($_POST['dueDate'])) {
			try {				
				$task->updated_by = \Auth::id();
				$task->due_date = Carbon::parse($request->input('dueDate'));
				
				$task->description = $request->input('description');
				
				$task->tags()->delete(); // Remove all current hashtags associated with this task
				
				// TODO: If tag name is an email, add user to assigned_to field
				$hashTags = Helper::create()->getTagsFromString($request->input('description'));  
				
				\DB::transaction(function() use ($task, $hashTags) {
				
					foreach($hashTags as $tagName){
						$tag = Tag::where('name', '=', $tagName)
							->where('user_id', '=', \Auth::id())->first();
						
						if($tag) {
							$task->tags()->save($tag);  // Save tag to task
						} else {
							$tag = new Tag();  // Create new tag
							$tag->name = $tagName;
							$tag->user_id = \Auth::id();
							$task->tags()->save($tag);
							//$tag->save();
						}
					}
					
					$task->save();
				});

			} catch(Exception $e) {
				
				$data = array('error' => 'Unable to update task record.');		
				//return  Response::json($data, 500);
			}
		}
		
		// Pass back some data, along with the original data, just to prove it was received
		$data = array('success' => 'Task updated successfully.', 'id' => $id, 'input' => $request->input());
		
		// Return the success JSON response
		return response()->json($data, 200);
	}
	
	/*
	 * Status update of the task that returns an ajax response
	 */
	public function ajaxStatus($id, Request $request)
	{
		$task = Task::findOrFail($id);
		
		if($task && isset($_POST['status'])) {
			try {
				$task->updated_by = \Auth::id();
				$task->status = $request->input('status');
				$task->save();
			} catch(Exception $e){
				$data = array('error' => 'Unable to update task status.');		
				//return  Response::json($data, 500);
			}
		}
		
		// Pass back some data, along with the original data, just to prove it was received
		$data = array('success' => 'Task status updated successfully.', 'id' => $id, 'input' => $request->input());
		
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
        $task = Task::with('project')->where('id', '=', $id)
			->where('user_id', '=', \Auth::id())
			->first();
		
		if($task) {
			$task->project->duration -= $task->duration; //Remove the task duration to the project duration
			$task->project->save();
			
			// Set the flash message for completing the deletion
			\Session::flash('alert-success', "Task deleted successfully.");
			$task->delete(); // Delete the task
		} else {
			\Session::flash('alert-danger', "You don't have permission to delete the task.");
		}
		
		// Return a collection of all the tasks for the user
		//$tasks = Task::where('user_id','=',\Auth::id())->orderBy('due_date', 'desc')->get();

		return redirect('home');		
		//return view('task.index')->with('tasks', $tasks);
		//return back()->withInput();
    }
}
