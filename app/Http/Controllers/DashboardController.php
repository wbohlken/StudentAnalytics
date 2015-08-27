<?php

namespace App\Http\Controllers;

use App\Model\CsvData;
use App\Model\MoodleResult;
use App\Model\MyprogramminglabResult;
use App\Model\WeekOverview;
use App\User;
use App\Model\Week;
use Input;
use App\Model\Student;
use Redirect;
use Session;
use App\Model\LyndaData;
use Validator;
use Illuminate\Support\Facades\DB;
use Auth;

class DashboardController extends Controller
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
     * Show the application dashboard to the user.
     *
     * @return Response
     */
    public function getIndex()
    {
        if (Auth::check() && !Auth::user()->isStudent()) {
            $studentnumbers = Student::getAllStudentnumbers();
            $lastcsvdata = DB::table('csv_data')->orderBy('created_at', 'desc')->first();

            $countStudents = Student::all()->count();
            $countUsers = User::all()->count();
            $countAdmins = User::where('admin', 1)->count();
            $lastweek = DB::table('week')->where('sent', '1')->orderBy('week_nr', 'desc')->first();
            $countOpenedDashboardsLastWeek = DB::table('week_overview')->whereNotNull('opened_on')->count();

            $weeks = Week::where('sent', '1');
            $allweeks = $weeks->lists('week_nr');
            if ($lastcsvdata) {
                $dateLastCSVdata = date('d-m-Y', strtotime($lastcsvdata->created_at));
            } else {
                $dateLastCSVdata = '';
            }
            if ($lastweek) {
                $lastSendWeek = $lastweek->week_nr;
                $dateSendWeek = date('d-m-Y', strtotime($lastweek->created_at));
            } else {
                $lastSendWeek = '';
                $dateSendWeek = '';
            }
            return view('dashboard', ['user' => Auth::user(), 'studentnumbers' => $studentnumbers, 'countStudents' => $countStudents, 'countUsers' => $countUsers, 'countAdmins' => $countAdmins, 'sendWeek' => $lastSendWeek, 'countOpened' => $countOpenedDashboardsLastWeek, 'dateSendWeek' => $dateSendWeek, 'allweeks' => $allweeks, 'dateLastCSVdata' => $dateLastCSVdata]);
        } else {
            Auth::logout();
            return redirect('/');
        }
    }

    public function createdashboards() {
        if (Auth::user()->isAdmin()) {
            $week_nr = Input::get('week');

            $oWeek = Week::where('week_nr', $week_nr)->first();

            $ooStudents = Student::all();

            if ($week_nr !== '7') {
                foreach ($ooStudents as $oStudent) {
                    $oWeekOverview = new WeekOverview();
                    $oWeekOverview->student_id = $oStudent->id;
                    $oWeekOverview->week_id = $oWeek->id;
                    $oWeekOverview->save();

                    $oCsvData = CsvData::where('studnr_a', $oStudent->studnr_a)->first();

                    $aMoodleTypes = ['quiz', 'prac'];

                    foreach ($aMoodleTypes as $aMoodleType) {
                        $field = 'w' . $week_nr . '_' . $aMoodleType;

                        $oMoodleResult = new MoodleResult();
                        $oMoodleResult->week_overview_id = $oWeekOverview->id;
                        $oMoodleResult->grade = $oCsvData->$field;
                        $oMoodleResult->type = $aMoodleType;
                        $oMoodleResult->save();
                    }

                    $oLyndaResult = new LyndaData();
                    $oLyndaResult->week_overview_id = $oWeekOverview->id;
                    $oLyndaResult->course_id = $oCsvData['Course'];
                    $oLyndaResult->complete = $oCsvData['complete'];
                    $oLyndaResult->hours_viewed = $oCsvData['Hoursviewed'];
                    $oLyndaResult->save();

                    $MMLAttempts = 'W' . $week_nr . '_MMLAttemps';
                    $MMLMastery = 'W' . $week_nr . '_MMLMastery';

                    $myprogrammingLabResult = new MyprogramminglabResult();
                    $myprogrammingLabResult->week_overview_id = $oWeekOverview->id;
                    $myprogrammingLabResult->MMLAttempts = $oCsvData->$MMLAttempts;
                    $myprogrammingLabResult->MMLMastery = $oCsvData->$MMLMastery;
                    $myprogrammingLabResult->save();

                }
            } else {
                //Week 7 not everything is done.
                foreach ($ooStudents as $oStudent) {
                    $oWeekOverview = new WeekOverview();
                    $oWeekOverview->student_id = $oStudent->id;
                    $oWeekOverview->week_id = $oWeek->id;
                    $oWeekOverview->save();

                    $oCsvData = CsvData::where('studnr_a', $oStudent->studnr_a)->first();

                    $oLyndaResult = new LyndaResult();
                    $oLyndaResult->week_overview_id = $oWeekOverview->id;
                    $oLyndaResult->complete = $oCsvData['complete'];
                    $oLyndaResult->hours_viewed = $oCsvData['Hoursviewed'];
                    $oLyndaResult->save();

                    // Week 7 oefen toets
                    $moodleResult = new MoodleResult();
                    $moodleResult->week_overview_id = $oWeekOverview->id;
                    $moodleResult->assignment_week_nr = 7;
                    $moodleResult->type = 'oefen_toets';
                    $moodleResult->grade = $oCsvData['w7_oefen_toets'];
                    $moodleResult->save();
                }
            }
            exec('sudo sh /usr/share/kettle/data-integration/kitchen.sh -file=/usr/share/kettle/kettle_config/hva.kjb -param:CONFIG_DIR=/usr/share/kettle/kettle_config/ -param:weeknr='. $week_nr);

            // Return will return non-zero upon an error
            $oWeek->dashboard_created = 1;
            $oWeek->save();

            $oWeekOverviewCount = WeekOverview::where('week_id', $oWeek->id)->count();
            Session::flash('success', 'Alle ' . $oWeekOverviewCount . ' dashboards zijn aangemaakt!');
            return redirect('/dashboard-versturen');
        } else {
            return redirect('/');
        }

    }

    public function createStudents()
    {
        if (Auth::user()->isAdmin()) {
            $csvdata = CsvData::all()->toArray();
            foreach ($csvdata as $row) {
                $studnr_a = $row['studnr_a'];
                // create student if not exists;
                Student::createByStudnr($studnr_a);
            }
            $aUsedStudentIds = array();


            //get for every direction the amount of students
            //Defined in DB table 'direction'
            //Business IT & Management = 1;
            //Game Development = 2;
            //Software Engineering = 3;
            //System & Network Engineering = 4;
            //Technical Computing = 5;

            $amountBIMStudents = Student::where('direction_id', 1)->count();
            $amountGDStudents = Student::where('direction_id', 2)->count();
            $amountSEStudents = Student::where('direction_id', 3)->count();
            $amountSMStudents = Student::where('direction_id', 4)->count();
            $amountTCStudents = Student::where('direction_id', 5)->count();

            //Save every key value pair in array
            $aDirectionsAmounts[1] = $amountBIMStudents;
            $aDirectionsAmounts[2] = $amountGDStudents;
            $aDirectionsAmounts[3] = $amountSEStudents;
            $aDirectionsAmounts[4] = $amountSMStudents;
            $aDirectionsAmounts[5] = $amountTCStudents;

            //loop through array with key value pair
            foreach ($aDirectionsAmounts as $key => $value) {
                //for every number from 0 till 50% of amount of students in this direction create an user.
                for ($i = 0; $i < floor($value / 2); $i++) {

                    // Select the user by direction_id and look if it is not already in array, select it random!
                    $student = Student::orderByRaw("RAND()")->where('direction_id', $key)->whereNotIn('id', $aUsedStudentIds)->first();

                    //put found student in array
                    $aUsedStudentIds[] = $student->id;
                    //Create the user by the id
                    User::createByStudentId($student);
                }
            }
            $amountUsers = User::whereNotNull('student_id')->count();

            Session::flash('success', 'Alle studenten en ' . $amountUsers . ' gebruikers zijn aangemaakt!');

            return redirect('/dashboard');
        } else {
            return redirect('/');
        }
    }


    public function versturenAction()
    {
        if (Auth::user()->isAdmin()) {
            $weeks = Week::where('sent', '1');
            $dashboard = Week::where('dashboard_created', '1');
            $alldashboard = $dashboard->lists('week_nr');
            $allweeks = $weeks->lists('week_nr');
            $countUsers = User::where('admin', 0)->count();

            return view('versturen', ['allweeks' => $allweeks, 'weeks' => $weeks, 'countUsers' => $countUsers, 'dashboard' => $alldashboard]);
        } else {
            return redirect('/');
        }
    }
}
