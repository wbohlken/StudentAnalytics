<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;
use App\Model\WeekOverview;
use Illuminate\Support\Facades\Mail;

class Student extends Model {
	protected $table = "student";

	protected $fillable = ['studnr_a', 'block', 'cohort_block', 'cohort_year', 'preschool_type', 'profile', 'preschool_profile'];

	public function weekOverviews()
	{
		return $this->hasMany('App\Model\WeekOverview');
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
            
            return WeekOverview::where('student_id', $this->id)->where('week_id', $week)->first();
            
            
        }
        
        public function sendMail($weekoverview) {
            Mail::send('emails.weekoverview', ['view_key' => $weekoverview->view_key], function($message)
            {
                $message->to('Justin.oud@hotmail.com', 'John Smith')->subject('Je dashboard voor deze week!');
            });
        }
}