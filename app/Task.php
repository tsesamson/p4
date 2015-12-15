<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Helper as Helper;

class Task extends Model
{
    public function project() {
		# Task belongs to Project (one-to-many)
		return $this->belongsTo('\App\Project');
	}
	
	public function user() {
		# Task belongs to User (one-to-many)
		return $this->belongsTo('\App\User');
	}
	
    public function timers() {
		# Task has many Timers (one-to-many)
		return $this->hasMany('\App\Timer');
	}
	
    public function tags() {
		# Set many-to-many relationship, withTimestamps() will ensure the pivot table has its timestamps fields maintained automatically
		return $this->belongsToMany('\App\Tag')->withTimestamps();
	}
	
	/*
	 * Trying to create a method that returns the duration field
	 */
	public function duration() {
		
		if($this->duration == 0){
			return '';
		} else {
			return Helper::create()->getSecondsInDuration($this->duration);
		}
		
		return $this->duration;
	}
	
	/*
	 * Creating a method that will return due date in date format that matches the datepicker js
	 */
	public function dueDate() {
		$t = strtotime($this->due_date);
		return date('m/d/Y', $t);
	}
	
	/*
	 * Overriding save method to include user check
	 */
	public function save(array $options = array())
	{
		// Check to see if the current user has permission to update the record
		// TODO: Check if the user is in the project_users table with admin permission
		if($this->user_id == /Auth::id() || $this->assigned_to == \Auth::id()) {
			parent::save($options);
		} else {
			abort(403, 'Unauthorized action.');
		}
	}
	
}
