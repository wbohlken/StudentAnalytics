<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;


class VooroplProfiel extends Model {
	protected $table = "vooropl_profiel";

	protected $fillable = ['name'];

	public function students() {
		return $this->hasMany('App\Model\Student');
	}
}