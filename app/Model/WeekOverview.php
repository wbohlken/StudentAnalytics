<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class WeekOverview extends Model {
	protected $table = "week_overview";

	public function moodleResult()
	{
		return $this->hasMany('App\Model\MoodleResult');
	}

	public function lyndaData()
	{
		return $this->hasMany('App\Model\LyndaData');
	}

	public function myprogramminglabResult()
	{
		return $this->hasMany('App\Model\MyprogramminglabResult');
	}

	public function myprogramminglabTotal()
	{
		return $this->hasOne('App\Model\MyprogramminglabTotal');
	}

	public function student()
	{
		return $this->belongsTo('App\Model\Student');
	}

	public function week()
	{
		return $this->belongsTo('App\Model\Week');
	}

	public static function getByViewKey($viewKey) {
		return self::with('moodleResult', 'lyndaData', 'myprogramminglabResult', 'myprogramminglabTotal')
				->where('view_key', $viewKey)->first();
	}
}