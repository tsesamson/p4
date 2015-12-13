<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
}
