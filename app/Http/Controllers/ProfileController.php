<?php namespace App\Http\Controllers;

use App\Model\CsvData;
use Request;
use Input;
use Redirect;
use Session;
use Validator;
use Auth;
use View;
class ProfileController extends Controller {

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
	public function index()
	{

                $user = auth::user();
                

                if (Request::isMethod('post'))
                {
                    if (Input::get('command') == 'editprofile') {
                        $name = Input::get('name');
                        $studentnumber = Input::get('studentnumber');
                        $email = Input::get('email');
                        $user->name = $name;
//                        $user->studentnumber = $studentnumber;
                        $user->email = $email;
                        if ($user->save()) {
                            Session::flash('success', 'je profiel is gewijzigd!');
                        } else {
                            Session::flash('error', 'je profiel kon niet opgeslagen worden');
                        }
                    }
                }
                return View::make('profile')->with('user', $user);
                
                
	}
        
        
}
