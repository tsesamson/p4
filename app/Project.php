<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public function task() {
		# Project has many Tasks (one-to-many)
		return $this->hasMany('\App\Task');
	}
}
