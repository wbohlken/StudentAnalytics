<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Student extends Model {
	protected $table = "student";

	public function weekOverviews()
	{
		return $this->hasMany('App\Model\WeekOverview');
	}
}