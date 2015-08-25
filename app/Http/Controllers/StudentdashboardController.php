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
use Illuminate\Support\Facades\URL;

class StudentdashboardController extends Controller
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
     * Show the application studentdashboard to the student.
     *
     * @return Response
     */
    public function getIndex()
    {
        $aSentWeeks = Week::where('sent', 1)->lists('week_nr');
        $aStudentnumbers = Student::getAllStudentnumbers();
        // if admin is checking the studentdashboards
        if (Input::has('studentnumber') && !Input::has('week')) {
            if (!Auth::user()->isStudent()) {

                $studentnumber = Input::get('studentnumber');
                $oStudent = Student::where('studnr_a', $studentnumber)->first();


                //get first weekoverview if nothing is specified.
                $oWeekOverview = $oStudent->getWeekOverview(1);

                //get mainresult for this weekoverview
                //get averageresults for all students
                //Pass weekoverview to view by transform it to array
                $aMainResults = $oWeekOverview->getMainResults();
                $aAverageResults = $oWeekOverview->getAverageResults();
                $aWeekOverview = $oWeekOverview->toArray();
                return view('studentdashboard', ['studentnumber' => $studentnumber, 'student' => $oStudent, 'studentnumbers' => $aStudentnumbers, 'mainResults' => $aMainResults, 'averageResults' => $aAverageResults, 'weekOverview' => $aWeekOverview, 'sentweeks' => $aSentWeeks, 'week' => 1]);
            } else {
                return redirect('/');
            }
            // if student is checking their own studentdashboards
        } elseif (Input::has('key')) {
            $viewKey = Input::get('key');

            //Log the user in with the view key
            if (!User::loginByViewKey($viewKey)) {
                // Show the view with wrong key message
                return view('wrongkey');
            }

            //Get the weekoverview by view key and get all variables used in studentdashboard
            $oWeekOverview = WeekOverview::getByViewKey($viewKey);
            $aMainResults = $oWeekOverview->getMainResults();
            $aAverageResults = $oWeekOverview->getAverageResults();
            $oWeek = $oWeekOverview->week;
            $aWeekOverview = $oWeekOverview->toArray();
            $oStudent = Student::where('studnr_a', $oWeekOverview->student_id)->first();
            $oWeekOverviews = WeekOverview::where('student_id', $oStudent->studnr_a)->get();

            // Make array with existing view_keys for this student.
            // By having this array the student can easily swap between their existing and already sent weekoverviews.
            $aKeysOverviews = array();
            foreach ($oWeekOverviews as $oWeekOverview) {
                $aKeysOverviews[$oWeekOverview->week->week_nr] = $oWeekOverview->view_key;
            }
            return view('studentdashboardview', ['student' => $oStudent, 'studentnumbers' => $aStudentnumbers, 'mainResults' => $aMainResults, 'averageResults' => $aAverageResults, 'weekOverview' => $aWeekOverview, 'sentweeks' => $aSentWeeks, 'week' => $oWeek->week_nr, 'viewkeys' => $aKeysOverviews]);
        } elseif (Input::has('week')) {
            // if admin is watching the studentdashboards for specific weeks.
            $week = Input::get('week');
            return $this->getWeekOverviewDashboard($week);
        }

        //Students cannot see the main studentdashboard, because their prohibited to find other students dashboards.
        if (!Auth::user()->isStudent()) {
            return view('weekdashboard', ['studentnumbers' => $aStudentnumbers]);
        } else {
            return Redirect::to(URL::previous());
        }

    }

    /**
     * Get the specific weekoverview for this week
     * ONLY for admins
     * @return View or URL;
     */

    public function getWeekOverviewDashboard($week)
    {

        $oWeek = Week::where('week_nr', $week)->first();

        if (Input::has('studentnumber')) {
            $oStudent = Student::where('studnr_a', Input::get('studentnumber'))->first();
        }
        if (Auth::user()->isAdmin()) {
            if (Input::has('studentnumber')) {
                if ($oWeek) {
                    $oWeekOverview = WeekOverview::where('week_id', $oWeek->id)->where('student_id', $oStudent->studnr_a)->first();
                } else {
                    $oWeekOverview = null;
                }
            } elseif (Input::get('key')) {
                $oWeekOverview = WeekOverview::where('key', Input::get('key'))->first();
            }
        } else {
            if ($oWeek->sent = 1) {
                if (Input::has('studentnumber')) {
                    $oWeekOverview = WeekOverview::where('week_id', $oWeek->id)->where('student_id', $oStudent->studnr_a)->first();
                } elseif (Input::get('key')) {
                    $oWeekOverview = WeekOverview::where('key', Input::get('key'))->first();
                }
            } else {
                Session::flash('error', 'Je kan dit dashboard niet bekijken, wacht tot deze is verzonden');
                return Redirect::to(URL::previous());
            }
        }
        // if weekoverview is found, get all the variables for the dashboard.
        if ($oWeekOverview) {

            $aMainResults = $oWeekOverview->getMainResults();
            $aAverageResults = $oWeekOverview->getAverageResults();
            $aStudentnumbers = Student::getAllStudentnumbers();
            $aWeekOverview = $oWeekOverview->toArray();
            $aSentWeeks = Week::where('sent', 1)->lists('week_nr');
            $studentnumber = Input::get('studentnumber');

            return view('studentdashboard', ['studentnumber' => $studentnumber, 'student' => $oStudent, 'studentnumbers' => $aStudentnumbers, 'mainResults' => $aMainResults, 'averageResults' => $aAverageResults, 'weekOverview' => $aWeekOverview, 'sentweeks' => $aSentWeeks, 'week' => $oWeek->week_nr]);
        } else {
            // if nothing is found get only the MUST ones, all the others set to NULL.
            $aMainResults = null;
            $aAverageResults = null;
            $aStudentnumbers = Student::getAllStudentnumbers();
            $aWeekOverview = null;
            $oWeekNr = Input::get('week');
            $aSentWeeks = Week::where('sent', 1)->lists('week_nr');
            $studentnumber = Input::get('studentnumber');
            return view('studentdashboard', ['studentnumber' => $studentnumber, 'student' => $oStudent, 'studentnumbers' => $aStudentnumbers, 'mainResults' => $aMainResults, 'averageResults' => $aAverageResults, 'weekOverview' => $aWeekOverview, 'sentweeks' => $aSentWeeks, 'week' => $oWeekNr]);

            Session::flash('error', 'Je kan dit dashboard niet bekijken, deze is nog niet aangemaakt');
            return Redirect::back();
        }
    }

}
