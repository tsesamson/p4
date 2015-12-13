<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Timer extends Model
{
    public function task() {
		# Timer belongs to Task (one-to-many)
		return $this->belongsTo('\App\Task');
	}

}
