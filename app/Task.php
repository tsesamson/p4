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
	
    public function timer() {
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
}
