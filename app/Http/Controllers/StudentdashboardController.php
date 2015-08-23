<?php

namespace App\Http\Controllers;

use App\Model\CsvData;
use App\Model\WeekOverview;
use App\Model\WeekOverviewHistory;
use App\User;
use App\Model\Week;
use Input;
use App\Model\Student;
use Redirect;
use Session;
use Validator;
use Illuminate\Support\Facades\DB;
use Auth;

class StudentdashboardController extends Controller {
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
    public function __construct() {
        
    }

    /**
     * Show the application studentdashboard to the student.
     *
     * @return Response
     */
    public function getIndex() {

        // if admin is checking the studentdashboards
        if (Input::has('studentnumber')) {
            if (Auth::user()->isAdmin()) {
                $studentnumber = Input::get('studentnumber');
                $oStudent = Student::where('studnr_a', $studentnumber)->first();
                $aStudent = $oStudent->toArray();

                //get always first weekoverview.
                $oWeekOverview = $oStudent->getWeekOverview(1);
                $aMainResults = $oWeekOverview->getMainResults();
                $aAverageResults = $oWeekOverview->getAverageResults();
                $aStudentnumbers = Student::getAllStudentnumbers();

                $aWeekOverview = $oWeekOverview->toArray();
                return view('studentdashboard', ['studentnumber' => $studentnumber, 'student' => $aStudent, 'studentnumbers' => $aStudentnumbers, 'mainResults' => $aMainResults, 'averageResults' => $aAverageResults, 'weekOverview' => $aWeekOverview]);
            }
            // if student is checking their own studentdashboards
        } elseif (Input::has('key')) {
            $viewKey = Input::get('key');

            //Log the user in with the view key
            if (!User::loginByViewKey($viewKey)) {
                // Show the view with wrong key message
                return view('wrongkey');
            }
            //Get the weekoverview by view key
            $oWeekOverview = WeekOverview::getByViewKey($viewKey);
            $aMainResults = $oWeekOverview->getMainResults();
            $aAverageResults = $oWeekOverview->getAverageResults();

            $aWeekOverview = $oWeekOverview->toArray();
            $aStudentnumbers = Student::getAllStudentnumbers();
            $aStudent = Student::where('id', $oWeekOverview->student_id)->first();
            return view('studentdashboard', ['student' => $aStudent, 'studentnumbers' => $aStudentnumbers, 'mainResults' => $aMainResults, 'averageResults' => $aAverageResults, 'weekOverview' => $aWeekOverview]);
        }
        $aStudentnumbers = Student::getAllStudentnumbers();

        return view('weekdashboard', ['studentnumbers' => $aStudentnumbers]);


        
    }

    public function getWeekOverviewDashboard() {
        if (Input::has('week')) {
            $week = Input::get('week');
        }
    }

}
