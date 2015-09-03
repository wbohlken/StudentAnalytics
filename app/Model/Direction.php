<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;


class Direction extends Model
{
    protected $table = "direction";

    protected $fillable = ['name'];

    public function students()
    {
        return $this->hasMany('App\Model\Student');
    }
}