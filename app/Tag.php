<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public function tasks() {
		# Set many-to-many relationship, withTimestamps() will ensure the pivot table has its timestamps fields maintained automatically
		return $this->belongsToMany('\App\Task')->withTimestamps();
	}
}
