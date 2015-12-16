<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public function tasks() {
		# Project has many Tasks (one-to-many)
		return $this->hasMany('\App\Task');
	}

	/*
	 * Creating a method that will return start date in date format that matches the datepicker js
	 */
	public function startDate() {
		$t = strtotime($this->start_date);
		return date('m/d/Y', $t);
	}

	/*
	 * Creating a method that will return end date in date format that matches the datepicker js
	 */
	public function endDate() {
		$t = strtotime($this->end_date);
		return date('m/d/Y', $t);
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
		if($this->user_id == \Auth::id()) {
			parent::save($options);
		} else {
			abort(403, 'Unauthorized action.');
		}
	}
	
}
