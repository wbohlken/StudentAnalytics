<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class MyprogramminglabTotal extends Model {
	protected $table = "myprogramminglab_total";
	protected $fillable = ['MMLMastery', 'MMLAttempts', 'week_overview_id'];


}