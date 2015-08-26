<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;
use App\Model\WeekOverview;
use Illuminate\Support\Facades\Mail;
use App\Model\VooroplProfiel;
use Illuminate\Support\Facades\DB;

class Student extends Model {
	protected $table = "student";

	protected $fillable = ['studnr_a', 'block', 'cohort_block', 'cohort_year', 'preschool_type', 'profile', 'preschool_profile'];

	public function weekOverviews()
	{
		return $this->hasMany('App\Model\WeekOverview');
	}

    public function user() {
        return $this->hasOne('App\User');
    }

    public function vooropl_profiel()
    {
        return $this->belongsTo('App\Model\VooroplProfiel', 'preschool_profile');
    }

    public function direction()
    {
        return $this->belongsTo('App\Model\Direction', 'direction_id');
    }

	public static function createByStudnr($studnr_a)
	{
            
		$student = self::where('studnr_a', $studnr_a)->first();
                
                $csvdata = CsvData::where('studnr_a', $studnr_a)->first();
               
		if (!$student) {
			$student = new Student(['studnr_a' => $studnr_a, 'block' => $csvdata->cohort, 'cohort_block' => $csvdata->cohort_blok, 'cohort_year' => $csvdata->cohort_jaar, 'preschool_type' => $csvdata->vooropl_type, 'profile' => $csvdata->profiel, 'preschool_profile' => $csvdata->vooropl_profiel]);
                        $student->save();
                        
		}
		return $student;
	}
          public static function getAllStudentnumbers() {
            $studentnumbers = \DB::table('student')->lists('studnr_a');
            return $studentnumbers;
        }
        
        public function getWeekOverview($week) {
            
            return WeekOverview::where('student_id', $this->studnr_a)->where('week_id', $week)->first();
            
            
        }

    // get amount of logins by this user
    // param (Week)
    public function getAmountLoggedIn($week = false)
    {

            if (count($this->user)) {

                $user = $this->user;

                if (!$week) {
                    return WeekOverviewHistory::where('user_id', $user->id)->count();
                } else {
                    return DB::table('week_overview_history')->join('week_overview', 'week_overview_history.week_overview_id', '=', 'week_overview.id')
                                                             ->where('week_overview.week_id', '=' , $week)
                                                             ->where('user_id', '=', $user->id)
                                                             ->count();
                }
            } else {
                return 0;
            }

    }

    public function getLastLogin() {
        if(count($this->user)) {
            $user = $this->user;
            return WeekOverviewHistory::where('user_id', $user->id)->orderBy('created_at','desc')->first(['created_at']);
        }
    }

    public function getLatestWeekOverview() {
            return WeekOverview::where('student_id', $this->studnr_a)->orderBy('created_at', 'desc')->first();
    }
        
        public function sendMail($weekoverview) {
            Mail::queue('emails.weekoverview', ['view_key' => $weekoverview->view_key], function($message)
            {
                $message->to('Justin.oud@hotmail.com', 'John Smith')->subject('Je programming dashboard voor deze week.');
            });
        }

        public function getOverviewByFilter($filter) {
            $student = $this;
            if($filter['vooropl']) {
                $student = $this->join('week_overview as week_overview_1', 'week_overview_history.week_overview_id', '=', 'week_overview_1.id')->join('student', 'week_overview_1.student_id', '=', 'student.id')->where('student.preschool_profile', $filter['vooropl']);
            }
            if($filter['studentnumber']) {
                $student = $this->join('week_overview as week_overview_2', 'week_overview_history.week_overview_id', '=', 'week_overview_2.id')->join('student', 'week_overview_2.student_id', '=', 'student.id')->where('student.studnr_a', $filter['studentnumber']);
            }
            if($filter['week']) {
                $student = $this->join('week_overview as week_overview_3', 'week_overview_history.week_overview_id', '=', 'week_overview_3.id')->join('week', 'week_overview_3.week_id', '=', 'week.id')->where('week.week_nr', $filter['week']);
            }

            return $student->paginate(25);
        }




}