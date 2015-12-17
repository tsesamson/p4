<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Helper as Helper;
use Carbon\Carbon;

class Timer extends Model
{
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'start', 'stop', 'deleted_at', ];
	
    public function task() {
		# Timer belongs to Task (one-to-many)
		return $this->belongsTo('\App\Task');
	}

	// Start the current timer
	public function start() {
		$this->start = Carbon::now();
		$this->created_by = \Auth::id();
		$this->updated_by = \Auth::id();
	}
	
	// Stop the current timer and save();
	public function stop() {
		$this->stop = Carbon::now();
		$this->updated_by = \Auth::id();
		
		// Get the start/stop difference to calculate duration
		$this->duration = $this->stop->diffInSeconds($this->start);
		$this->save();
	}

	// Stop the current timer by using the most recent duration (in seconds) logged and save();
	public function stopByDuration($duration) {
		$this->stop = $this->start->addSeconds($duration); //Use the duration passed in by js timer to sync the time
		$this->updated_by = \Auth::id();
		
		// Get the start/stop difference to calculate duration
		//$this->duration = $this->stop->diffInSeconds($this->start);
		$this->duration = $duration;
		$this->save();
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
