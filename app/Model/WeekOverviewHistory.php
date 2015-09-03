<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class WeekOverviewHistory extends Model
{

    protected $table = "week_overview_history";
    protected $fillable = ['user_id', 'week_overview_id'];


    public function WeekOverview()
    {
        return $this->belongsTo('App\Model\WeekOverview');
    }

    public function User()
    {
        return $this->belongsTo('App\User');
    }

    public function getOverviewByFilter($filter)
    {

        $oWeekOverviewHistory = $this;
        if ($filter['vooropl']) {
            $oWeekOverviewHistory = $this->join('week_overview as week_overview_1', 'week_overview_history.week_overview_id', '=', 'week_overview_1.id')->join('student', 'week_overview_1.student_id', '=', 'student.id')->where('student.preschool_profile', $filter['vooropl']);
        }
        if ($filter['studentnumber']) {
            $oWeekOverviewHistory = $this->join('week_overview as week_overview_2', 'week_overview_history.week_overview_id', '=', 'week_overview_2.id')->join('student', 'week_overview_2.student_id', '=', 'student.id')->where('student.studnr_a', $filter['studentnumber']);
        }
        if ($filter['week']) {
            $oWeekOverviewHistory = $this->join('week_overview as week_overview_3', 'week_overview_history.week_overview_id', '=', 'week_overview_3.id')->join('week', 'week_overview_3.week_id', '=', 'week.id')->where('week.week_nr', $filter['week']);
        }

        return $oWeekOverviewHistory->orderBy('created_at', 'desc')->paginate(25);

    }
}

