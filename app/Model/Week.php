<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Week extends Model {
	protected $table = "week";

	public function metadata()
	{
		return $this->hasOne('App\Model\Metadata');
	}

}