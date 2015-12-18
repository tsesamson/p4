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

class TagController extends Controller
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
	 * Auto-complete or Typeahead route for tags
	 */
	public function ajaxSearch($q)
	{
		$tags = Tag::select('name')->where('user_id', '=', \Auth::id())->where('name', 'like', $q . '%')->take(10)->get();  // Find the first 10 records that matches the tags query
		$projects = Project::select('name')->where('user_id', '=', \Auth::id())->where('name', 'like', $q . '%')->take(10)->get(); // Find the first 10 records that matches project name
		$result = array();
		
		if(count($tags)>0 && count($projects)>0) {
			
			$result = array_merge(get_object_vars($tags), get_object_vars($projects));
			
		} else if(count($tags)>0 && count($projects)==0){
			
			$result = $tags;
			
		} else if(count($tags)==0 && count($projects)>0){
			
			$result = $projects;
		}
		
		$data = array('search_results' => $result);
		
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
