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

	public static function boot()
	{
		parent::boot();

		WeekOverview::creating(function($weekOverview){
			$weekOverview->generateViewKey();
		});
	}

	public static function getByViewKey($viewKey) {
		return self::with('moodleResult', 'lyndaData', 'myprogramminglabResult', 'myprogramminglabTotal')
				->where('view_key', $viewKey)->first();
	}

	private function generateViewKey()
	{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$viewKey = '';
		for ($i = 0; $i < 64; $i++) {
			$viewKey .= $characters[rand(0, $charactersLength - 1)];
		}
		$this->view_key = $viewKey;
	}
}