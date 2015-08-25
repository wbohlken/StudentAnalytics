<?php namespace App\Http\Controllers;

use App\Model\Student;
use App\Model\WeekOverview;
use App\User;
use Illuminate\Http\Request;
use Input;
use Redirect;
use Session;
use Validator;
use Auth;

class HomeController extends Controller
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
        $this->middleware('guest');
    }

    /**
     * Show the application dashboard to the user.
     *
     * @return Response
     */
    public function index()
    {

        return view('/auth/login');
    }

    public function doLogin(Request $request)
    {
        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect('/');
        }

        return redirect('/auth/login')->withErrors([
            'email' => 'Dit e-mailadres en wachtwoord komen niet overeen',
        ]);
    }
//       
}
