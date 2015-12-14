<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Tag as Tag;
use App\Task as Task;
use App\Helpers\Helper as Helper;
use App\Project as Project;
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
		
		// Associate this user with all the proper user_id fields
		$task->user_id = \Auth::id();
		$task->created_by = \Auth::id();
		$task->updated_by = \Auth::id();
		//$task->assigned_to = \Auth::id();
		
		// Manually check duration field for error
		if(isset($_POST['txtInputDuration'])) {
			//if(Helper::create()->checkDuration($_POST['txtInputDuration'])){
			//	$this->validate->getMessageBag()->add('duration', 'Duration format is incorrect (i.e. 0:00:00).');
			//} else {
				$task->duration = Helper::create()->getDurationInSeconds($request->input('txtInputDuration'));
			//}
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
				$project->created_by = \Auth::id();
				$project->updated_by = \Auth::id();
				
			}
			
			$task->project_id = $project->id;
		}		

		$hashTags = array();
		if(isset($_POST['txtInputTaskDescription'])) {
			$hashTags = Helper::create()->getTagsFromString($request->input('txtInputTaskDescription'));  // Get the hashtags from description
			$task->description = $request->input('txtInputTaskDescription'); // Get the post field from request object
		}

		//Make sure the saving is done in a transaction so any error will be rollback
		\DB::transaction(function() use ($project, $task, $hashTags) {
			//$project = $project->save();  // Project needs to exists first
			$project->save();  // Project needs to exists first
			Project::find($project->id)->task()->save($task); // Task is saved to existing Project record
			
			
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
		
		return view('task.index')->with('tasks', $tasks);
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
		
		if(isset($_POST['txtHashTagSearch'])) {
				$hashTag = $request->input('txtHashTagSearch');
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
		
		return view('task.search')->with('tasks', $tasks)->with('hashTag', $hashTag);
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
