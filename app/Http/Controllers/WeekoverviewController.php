<?php namespace App\Http\Controllers;

use App\Model\CsvData;
use App\Model\WeekOverview;
use App\Model\Week;
use Input;
use App\Model\Student;
use Redirect;
use Session;
use App\Model\MoodleResult;
use App\Model\LyndaData;
use App\Model\MyprogramminglabResult;


class WeekoverviewController extends Controller
{

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{

	}

	/**
	 * Fire the specific week command to send all mails to students and create their dashboard. 
	 *
	 * @return Response
	 */
	public function fire()
	{
            if (Input::has('week')) {
                    $weeknumber = Input::get('week');
                    $data = CsvData::all()->toArray();
                    ini_set('max_execution_time', 300);
                    if ($this->createStudentDashboardForWeek($weeknumber, $data)) {
				Session::flash('success', 'De studentendashboards van week ' . $weeknumber . ' zijn aangemaakt en verstuurd!');
                    } else {
				Session::flash('error', 'De studenten dashboards zijn niet verstuurd');
                    }
                    return redirect('/dashboard');
                    
                    
            }
	}
        
        private function createStudentDashboardForWeek($weeknumber, $data) {
            
                // first create the new week
                $week = new Week();
                $week->week_nr = $weeknumber;
                $week->date = date('Y-m-d');
                $week->save(); 
                
                $moodleTypes = ['prac', 'quiz'];
                foreach ($data as $row) {
                        $oStudent = Student::where('studnr_a', $row['studnr_a'])->first();
                        //create weekoverview for this student
                        $oWeekOverview = new WeekOverview();
                        $oWeekOverview->student_id = $oStudent->id;
                        $oWeekOverview->week_id = $week->id;
                        $oWeekOverview->save();

                        //put moodleresult in DB
                        foreach ($moodleTypes as $moodleType) {
                            $grade = $row['w' . $week->week_nr . '_' . $moodleType];

                                $moodleResult = new MoodleResult();
                                $moodleResult->week_overview_id = $oWeekOverview->id;
                                $moodleResult->assignment_week_nr = $week->week_nr;
                                $moodleResult->type = $moodleType;
                                $moodleResult->grade = $grade;
                                $moodleResult->save();
                        }
                        // put lyndadata in DB 
                        $lyndaData = new LyndaData();
                        $lyndaData->week_overview_id = $oWeekOverview->id;
                        $lyndaData->course = $row['Course'];
                        $lyndaData->complete  = $row['complete'];
                        $lyndaData->hours_viewed = $row['Hoursviewed'];
                        $lyndaData->save();


                        //put MPL in DB
                        $MMLAttempts = $row['W' . $week->week_nr . '_MMLAttemps'];
                        $MMLMastery = $row['W' . $week->week_nr . '_MMLMastery'];

                        $myprogrammingLabResult = new MyprogramminglabResult();
                        $myprogrammingLabResult->assignment_week_nr = $week->week_nr;
                        $myprogrammingLabResult->week_overview_id = $oWeekOverview->id;
                        $myprogrammingLabResult->MMLAttempts = $MMLAttempts;
                        $myprogrammingLabResult->MMLMastery = $MMLMastery;
                        $myprogrammingLabResult->save();
                        
//                        $oStudent->sendMail($oWeekOverview);
                    
                }
                return true;
        }

	
        
        
}
