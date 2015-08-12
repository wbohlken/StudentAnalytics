<?php

namespace App\Http\Controllers;

use App\Model\CsvData;
use App\Model\WeekOverview;
use App\User;
use App\Model\Week;
use Input;
use App\Model\Student;
use Redirect;
use Session;
use Validator;
use Illuminate\Support\Facades\DB;
use Auth;

class DashboardController extends Controller {
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
     * Show the application dashboard to the user.
     *
     * @return Response
     */
    public function getIndex() {
        if (Auth::check()) {
            $studentnumbers = Student::getAllStudentnumbers();
            $lastcsvdata = DB::table('csv_data')->orderBy('created_at', 'desc')->first();

            $countStudents = Student::all()->count();
            $countUsers = User::all()->count();
            $countAdmins = User::where('admin', 1)->count();
            $lastweek = DB::table('week')->orderBy('week_nr', 'desc')->first();
            $countOpenedDashboardsLastWeek = DB::table('week_overview')->whereNotNull('opened_on')->count();
            $weeks = Week::all();
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
            return view('dashboard', ['studentnumbers' => $studentnumbers, 'countStudents' => $countStudents, 'countUsers' => $countUsers, 'countAdmins' => $countAdmins, 'sendWeek' => $lastSendWeek, 'countOpened' => $countOpenedDashboardsLastWeek, 'dateSendWeek' => $dateSendWeek, 'allweeks' => $allweeks, 'dateLastCSVdata' => $dateLastCSVdata]);
        } else {
            return redirect('/');
        }
    }

    public function createStudents() {
        $csvdata = CsvData::all()->toArray();
        foreach ($csvdata as $row) {
            $studnr_a = $row['studnr_a'];

            // create student if not exists;
            $student = Student::createByStudnr($studnr_a);

            // create user if not exists
            User::createByStudentId($student->id);
        }
        return redirect('/dashboard');
    }

}
