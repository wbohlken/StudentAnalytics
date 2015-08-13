<?php namespace App\Http\Controllers;

use App\Model\CsvData;
use App\Model\WeekOverview;
use App\Model\Week;
use Input;
use App\User;
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
                    if ($this->sendStudentDashboardForWeek($weeknumber, $data)) {
				Session::flash('success', 'De studentendashboards van week ' . $weeknumber . ' zijn aangemaakt en verstuurd!');
                    } else {
				Session::flash('error', 'De studenten dashboards zijn niet verstuurd');
                    }
                    return redirect('/dashboard');
            }
	}
        
        private function sendStudentDashboardForWeek($weeknumber) {
                // get week object for which studentdashboard is
                
                $oWeek = Week::where('week_nr', $weeknumber)->first();
                
                // get weekoverviews for this week
                $ooWeekOverviews = WeekOverview::where('week_id', $oWeek->id)->get();
                
                
                // for every weekoverview create view-key and send student their weekoverview
                // at the end, set the week on 'sent'. 
                foreach ($ooWeekOverviews as $oWeekOverview) {
                        //get student for this weekoverview
                        $oStudent = Student::where('id', $oWeekOverview->student_id)->first();
                        
                        //check if student has already user account
                        //NO? create user account
                        // create user if not exists
                        User::createByStudentId($oStudent->id);
                        
                        //generate viewkey for this weekoverview
                        $oWeekOverview->generateViewKey();
                        
                        // send mail to student
                        if ($oStudent->sendMail($oWeekOverview)) {
                            $oWeek->sent = 1;
                            $oWeek->save();
                        }
                        $oWeek->sent = 1;
                            $oWeek->save();
                }
                
                
                return true;
        }

	
        
        
}
