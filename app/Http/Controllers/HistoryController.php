<?php

namespace App\Http\Controllers;

use App\Model\Student;
use App\Model\VooroplProfiel;
use App\Model\WeekOverviewHistory;
use Auth;
use Illuminate\Pagination;
use Input;
use Redirect;
use Session;
use Validator;

class HistoryController extends Controller
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
            $vooropls = VooroplProfiel::all();
            $weekdashboardhistory = WeekOverviewHistory::orderBy('created_at', 'desc')->paginate(25);

            if (Input::get()) {
                $studentnumber = Input::get('studentnumber');
                $vooropleiding = Input::get('vooropl');
                $week = Input::get('week');

                $oWeekOverviewHistory = new WeekOverviewHistory();

                $aFilter = array('studentnumber' => $studentnumber, 'vooropl' => $vooropleiding, 'week' => $week);
                $oResult = $oWeekOverviewHistory->getOverviewByFilter($aFilter);

                return view('history', ['studentnumbers' => $studentnumbers, 'vooropls' => $vooropls, 'weekoverviewhistory' => $oResult, 'studentnumber' => $studentnumber, 'week' => $week, 'vooropleiding' => $vooropleiding]);
            }
            return view('history', ['studentnumbers' => $studentnumbers, 'vooropls' => $vooropls, 'weekoverviewhistory' => $weekdashboardhistory, 'studentnumber' => null, 'week' => null, 'vooropleiding' => null]);
            return redirect('/');
        }
    }


}
