<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Student extends Model {
	protected $table = "student";

	protected $fillable = ['studnr_a'];

	public function weekOverviews()
	{
		return $this->hasMany('App\Model\WeekOverview');
	}

	public static function createByStudnr($studnr_a)
	{
		$user = self::where('studnr_a', $studnr_a)->first();
		if (!$user) {
			$user = new self(['studnr_a' => $studnr_a]);
			$user->save();
		}
		return $user;
	}
}