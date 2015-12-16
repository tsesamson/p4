<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Helper as Helper;

class Timer extends Model
{
    public function task() {
		# Timer belongs to Task (one-to-many)
		return $this->belongsTo('\App\Task');
	}

	/*
	 * Trying to create a method that returns the proper format for duration field
	 */
	public function duration() {
		
		if($this->duration == 0){
			return '';
		} else {
			return Helper::create()->durationToString($this->duration);
		}
		
		return $this->duration;
	}
	
	/*
	 * Creating a method that will return start date in date format that matches the datepicker js
	 */
	public function startDate() {
		$t = strtotime($this->start);
		return date('m/d/Y', $t);
	}

	/*
	 * Creating a method that will return end date in date format that matches the datepicker js
	 */
	public function endDate() {
		$t = strtotime($this->end);
		return date('m/d/Y', $t);
	}
}
