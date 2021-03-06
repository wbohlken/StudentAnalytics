<?php

namespace App\Http\Controllers;

use App\Model\Student;
use App\Model\Week;
use App\User;
use Auth;
use Illuminate\Support\Facades\DB;
use Input;
use Redirect;
use Session;
use Validator;

class GeneralController extends Controller
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
            $lastCreatedWeek = DB::table('week')->where('dashboard_created', '1')->orderBy('week_nr', 'desc')->first();
            $countOpenedDashboardsLastWeek = DB::table('week_overview_history')->join('week_overview', 'week_overview_history.week_overview_id', '=', 'week_overview.id')->where('week_overview.week_id', $lastweek->id)->distinct('week_overview.user_id')->count();
            $weeks = Week::where('sent', '1');
            $allweeks = $weeks->lists('week_nr');


            if ($lastcsvdata) {
                $dateLastCSVdata = date('d-m-Y', strtotime($lastcsvdata->created_at));
            } else {
                $dateLastCSVdata = '';
            }
            if ($lastCreatedWeek) {
                $lastCreatedWeek = $lastCreatedWeek->week_nr;
            } else {
                $lastCreatedWeek = '';
            }

            if ($lastweek) {
                $lastSendWeek = $lastweek->week_nr;
                $dateSendWeek = date('d-m-Y', strtotime($lastweek->created_at));
            } else {
                $lastSendWeek = '';
                $dateSendWeek = '';
            }
            return view('algemeen', ['user' => Auth::user(), 'studentnumbers' => $studentnumbers, 'countStudents' => $countStudents, 'countUsers' => $countUsers, 'countAdmins' => $countAdmins, 'sendWeek' => $lastSendWeek, 'countOpened' => $countOpenedDashboardsLastWeek, 'dateSendWeek' => $dateSendWeek, 'lastCreatedWeek' => $lastCreatedWeek, 'allweeks' => $allweeks, 'dateLastCSVdata' => $dateLastCSVdata]);
        } else {
            return redirect('/');
        }
    }
}
