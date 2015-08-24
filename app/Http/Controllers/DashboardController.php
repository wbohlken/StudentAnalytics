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
        if (Auth::check() && !Auth::user()->isStudent()) {
            $studentnumbers = Student::getAllStudentnumbers();
            $lastcsvdata = DB::table('csv_data')->orderBy('created_at', 'desc')->first();

            $countStudents = Student::all()->count();
            $countUsers = User::all()->count();
            $countAdmins = User::where('admin', 1)->count();
            $lastweek = DB::table('week')->where('sent','1')->orderBy('week_nr', 'desc')->first();
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

    public function createStudents() {
        $csvdata = CsvData::all()->toArray();
        foreach ($csvdata as $row) {
            $studnr_a = $row['studnr_a'];
            // create student if not exists;
            Student::createByStudnr($studnr_a);
        }
        $aUsedStudentIds = array();
        // create user if not exists
        // ONLY create random the half
        $amountStudents = Student::all()->count();
        for ($i=0; $i < floor($amountStudents / 2); $i++) {
            $student = Student::orderByRaw("RAND()")->whereNotIn('id',$aUsedStudentIds)->first();
            $aUsedStudentIds[] = $student->id;
            User::createByStudentId($student);
        }


        Session::flash('success', 'Alle studenten en ' . floor($amountStudents / 2) . ' gebruikers zijn aangemaakt!');

        return redirect('/dashboard');
    }


    public function versturenAction() {
        $weeks = Week::where('sent', '1');
        $allweeks = $weeks->lists('week_nr');
        $countUsers = User::where('admin', 0)->count();

        return view('versturen', ['allweeks' => $allweeks, 'weeks' => $weeks, 'countUsers' => $countUsers]);
    }

    public function mail() {
        return view('emails.weekoverview');
    }
}
