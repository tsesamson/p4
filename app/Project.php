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
	 * Creating a method that will return due date in date format that matches the datepicker js
	 */
	public function dueDate() {
		$t = strtotime($this->due_date);
		return date('m/d/Y', $t);
	}
}
