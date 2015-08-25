<?php

namespace App\Http\Controllers;

use App\Model\CsvData;
use App\Model\VooroplProfiel;
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
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Pagination;

class StudentController extends Controller
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
        if (Auth::check()) {
            $studentnumbers = Student::getAllStudentnumbers();
            $vooropls = VooroplProfiel::all();
            $students = Student::paginate(25);

            if (Input::get()) {
                $studentnumber = Input::get('studentnumber');
                $vooropleiding = Input::get('vooropl');
                $week = Input::get('week');

                $oStudent = new Student();

                $aFilter = array('studentnumber' => $studentnumber, 'vooropl' => $vooropleiding, 'week' => $week);
                $oResult = $oStudent->getOverviewByFilter($aFilter);

                return view('students', ['studentnumbers' => $studentnumbers, 'vooropls' => $vooropls, 'students' => $oResult, 'studentnumber' => $studentnumber, 'week' => $week, 'vooropleiding' => $vooropleiding]);
            }
            return view('students', ['studentnumbers' => $studentnumbers, 'vooropls' => $vooropls, 'students' => $students, 'studentnumber' => null, 'week' => null, 'vooropleiding' => null]);

        }
    }


}
