<?php

namespace App\Http\Controllers;

use App\Model\Direction;
use App\Model\Student;
use App\Model\VooroplProfiel;
use Auth;
use Illuminate\Pagination;
use Input;
use Redirect;
use Session;
use Validator;

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
        if (Auth::check() && !Auth::user()->isStudent()) {
            $studentnumbers = Student::getAllStudentnumbers();
            $vooropls = VooroplProfiel::all();
            $students = Student::paginate(25);
            $directions = Direction::all();

            if (Input::get()) {
                $studentnumber = Input::get('studentnumber');
                $vooropleiding = Input::get('vooropl');
                $direction = Input::get('direction');

                $oStudent = new Student();

                $aFilter = array('studentnumber' => $studentnumber, 'vooropl' => $vooropleiding, 'direction' => $direction);
                $oResult = $oStudent->getOverviewByFilter($aFilter);

                return view('students', ['studentnumbers' => $studentnumbers, 'vooropls' => $vooropls, 'directions' => $directions, 'students' => $oResult, 'studentnumber' => $studentnumber, 'selecteddirection' => $direction, 'vooropleiding' => $vooropleiding]);
            }
            return view('students', ['studentnumbers' => $studentnumbers, 'vooropls' => $vooropls, 'students' => $students, 'studentnumber' => null, 'directions' => $directions, 'selecteddirection' => null, 'vooropleiding' => null]);

        }
    }


}
