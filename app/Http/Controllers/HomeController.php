<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Input;
use Redirect;
use Session;
use Validator;
use Auth;

use App\Library\CsvImporters\GlobalImporter;

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
		return view('dashboard');
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
//        public function doLogin()
//        {
//            
//                // validate the info, create rules for the inputs
//        $rules = array(
//            'email'    => 'required|email', // make sure the email is an actual email
//            'password' => 'required|alphaNum|min:3' // password can only be alphanumeric and has to be greater than 3 characters
//        );
//
//        // run the validation rules on the inputs from the form
//        $validator = Validator::make(Input::all(), $rules);
//
//        
//        // if the validator fails, redirect back to the form
//        if ($validator->fails()) {
//            return Redirect::to('login')
//                ->withErrors($validator) // send back all errors to the login form
//                ->withInput(Input::except('password')); // send back the input (not the password) so that we can repopulate the form
//        } else {
//            
//            // create our user data for the authentication
//            $userdata = array(
//                'email'     => Input::get('email'),
//                'password'  => Input::get('password')
//            );
//
//            
//            // attempt to do the login
//            if (Auth::attempt($userdata)) {
//                
//                // validation successful!
//                // redirect them to the secure section or whatever
//                // return Redirect::to('secure');
//                // for now we'll just echo success (even though echoing in a controller is bad)
//                return Redirect::to('/dashboard');
//
//            } else {        
//                // validation not successful, send back to form 
//                return Redirect::to('/home');
//
//            }
//
//        }
//        }
}
