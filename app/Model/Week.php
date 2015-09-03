<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Week extends Model
{
    protected $table = "week";

    protected $fillable = ['week_nr', 'date', 'sent', 'dashboard_created'];

    public function metadata()
    {
        return $this->hasOne('App\Model\Metadata');
    }

}